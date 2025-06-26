<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class FooterController extends Controller
{
    public function index()
    {
        return view('pages.editor.footer.index');
    }

    public function getData(Request $request)
    {
        $query = Footer::with(['createdBy', 'updatedBy'])
                      ->select('footer.*')
                      ->orderBy('created_at', 'desc');

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('profil_singkat', 'like', '%' . $searchTerm . '%')
                  ->orWhere('alamat_kantor', 'like', '%' . $searchTerm . '%');
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
                'profil_singkat' => 'required|string',
                'alamat_kantor' => 'required|string',
                'is_active' => 'required|boolean'
            ]);

            $data = [
                'profil_singkat' => $request->profil_singkat,
                'alamat_kantor' => $request->alamat_kantor,
                'is_active' => $request->is_active,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ];

            Footer::create($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data footer berhasil ditambahkan'
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
            $footer = Footer::findOrFail($request->id);
            
            return response()->json([
                'success' => 1,
                'data' => $footer
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
                'id' => 'required|exists:footer,id',
                'profil_singkat' => 'required|string',
                'alamat_kantor' => 'required|string',
                'is_active' => 'required|boolean'
            ]);

            $footer = Footer::findOrFail($request->id);

            $data = [
                'profil_singkat' => $request->profil_singkat,
                'alamat_kantor' => $request->alamat_kantor,
                'is_active' => $request->is_active,
                'updated_by' => Auth::id()
            ];

            $footer->update($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data footer berhasil diupdate'
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
                'id' => 'required|exists:footer,id'
            ]);

            $footer = Footer::findOrFail($request->id);
            $footer->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data footer berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}