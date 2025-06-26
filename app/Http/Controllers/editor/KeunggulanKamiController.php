<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\KeunggulanKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KeunggulanKamiController extends Controller
{
    public function index()
    {
        return view('pages.editor.home.keunggulankami.index');
    }

    public function data(Request $request)
    {
        $query = KeunggulanKami::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        return DataTables::of($query->ordered())
            ->addIndexColumn()
            ->addColumn('gambar_ikon', function ($row) {
                if ($row->gambar_ikon) {
                    return '<img src="' . $row->gambar_ikon_url . '" alt="Icon" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">';
                }
                return '<div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-image text-white"></i></div>';
            })
            ->addColumn('is_active', function ($row) {
                return $row->is_active ? 
                    '<span class="badge badge-success">Aktif</span>' : 
                    '<span class="badge badge-secondary">Tidak Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group" aria-label="Actions">';
                $btn .= '<button type="button" class="btn btn-sm btn-warning btnUpdate" data-id="' . $row->id . '" title="Edit"><i class="fa fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btnDelete" data-id="' . $row->id . '" title="Delete"><i class="fa fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['gambar_ikon', 'is_active', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar_ikon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
            'urutan' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            $data = $request->only(['judul', 'deskripsi', 'is_active', 'urutan']);
            
            // Safely get user ID
            $userId = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user ? $user->id : 0;
            }
            
            $data['created_by'] = $userId;
            $data['update_by'] = $userId;

            // Handle file upload
            if ($request->hasFile('gambar_ikon')) {
                $file = $request->file('gambar_ikon');
                $path = $file->store('keunggulan-kami', 'public');
                $data['gambar_ikon'] = $path;
            }

            KeunggulanKami::create($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data keunggulan berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function detail(Request $request)
    {
        try {
            $data = KeunggulanKami::findOrFail($request->id);
            
            return response()->json([
                'success' => 1,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:keunggulan_kami,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar_ikon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
            'urutan' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            $keunggulan = KeunggulanKami::findOrFail($request->id);
            
            $data = $request->only(['judul', 'deskripsi', 'is_active', 'urutan']);
            
            // Safely get user ID
            $userId = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user ? $user->id : 0;
            }
            
            $data['update_by'] = $userId;

            // Handle file upload
            if ($request->hasFile('gambar_ikon')) {
                // Delete old file if exists
                if ($keunggulan->gambar_ikon && Storage::disk('public')->exists($keunggulan->gambar_ikon)) {
                    Storage::disk('public')->delete($keunggulan->gambar_ikon);
                }
                
                $file = $request->file('gambar_ikon');
                $path = $file->store('keunggulan-kami', 'public');
                $data['gambar_ikon'] = $path;
            }

            $keunggulan->update($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data keunggulan berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $keunggulan = KeunggulanKami::findOrFail($request->id);
            
            // Safely get user ID
            $userId = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user ? $user->id : 0;
            }
            
            // Update delete_by before soft delete
            $keunggulan->update(['delete_by' => $userId]);
            
            // Delete file if exists
            if ($keunggulan->gambar_ikon && Storage::disk('public')->exists($keunggulan->gambar_ikon)) {
                Storage::disk('public')->delete($keunggulan->gambar_ikon);
            }
            
            $keunggulan->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data keunggulan berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}