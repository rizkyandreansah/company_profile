<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    public function index()
    {
        return view('pages.editor.tentangkami.portofolio.index');
    }

    public function getData(Request $request)
    {
        $query = Sertifikat::with(['createdBy', 'updatedBy'])
                          ->select('sertifikat.*')
                          ->orderBy('created_at', 'desc');

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('penerbit', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
            });
        }

        return DataTables::of($query)
            ->addColumn('created_by_name', function($row) {
                return $row->createdBy ? $row->createdBy->name : '-';
            })
            ->addColumn('updated_by_name', function($row) {
                return $row->updatedBy ? $row->updatedBy->name : '-';
            })
            ->make(true);
    }

    public function storeData(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:50',
                'penerbit' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'deskripsi' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Made optional
                'is_active' => 'required|boolean'
            ]);

            $data = [
                'judul' => $request->judul,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->is_active,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ];

            // Handle image upload (optional)
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('sertifikat', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            Sertifikat::create($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data sertifikat berhasil ditambahkan'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal menambahkan data: ' . $e->getMessage()
            ]);
        }
    }

    public function detail(Request $request)
    {
        try {
            $sertifikat = Sertifikat::findOrFail($request->id);
            
            return response()->json([
                'success' => 1,
                'data' => $sertifikat
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function updateData(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:sertifikat,id',
                'judul' => 'required|string|max:50',
                'penerbit' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'deskripsi' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional
                'is_active' => 'required|boolean'
            ]);

            $sertifikat = Sertifikat::findOrFail($request->id);
            $oldImage = $sertifikat->image;

            $data = [
                'judul' => $request->judul,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->is_active,
                'updated_by' => Auth::id()
            ];

            // Handle image upload (optional)
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('sertifikat', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            $sertifikat->update($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data sertifikat berhasil diupdate'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteData(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:sertifikat,id'
            ]);

            $sertifikat = Sertifikat::findOrFail($request->id);
            
            // Delete image if exists
            if ($sertifikat->image && Storage::disk('public')->exists($sertifikat->image)) {
                Storage::disk('public')->delete($sertifikat->image);
            }

            $sertifikat->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data sertifikat berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}