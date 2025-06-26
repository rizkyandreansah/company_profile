<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KebijakanPrivasi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class KebijakanPrivasiController extends Controller
{
    public function index()
    {
        return view('pages.editor.kebijakanprivasi.index');
    }

    public function getData(Request $request)
    {
        $query = KebijakanPrivasi::with(['createdBy', 'updatedBy'])
                      ->select('kebijakan_privasi.*')
                      ->orderBy('created_at', 'desc');

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
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
                'judul' => 'required|string|max:255',
                'content' => 'required|string',
                'is_active' => 'required|boolean'
            ]);

            $data = [
                'judul' => $request->judul,
                'content' => $request->content,
                'is_active' => $request->is_active,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ];

            KebijakanPrivasi::create($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data kebijakan privasi berhasil ditambahkan'
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
            $kebijakanPrivasi = KebijakanPrivasi::findOrFail($request->id);
            
            return response()->json([
                'success' => 1,
                'data' => $kebijakanPrivasi
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
                'id' => 'required|exists:kebijakan_privasi,id',
                'judul' => 'required|string|max:255',
                'content' => 'required|string',
                'is_active' => 'required|boolean'
            ]);

            $kebijakanPrivasi = KebijakanPrivasi::findOrFail($request->id);

            $data = [
                'judul' => $request->judul,
                'content' => $request->content,
                'is_active' => $request->is_active,
                'updated_by' => Auth::id()
            ];

            $kebijakanPrivasi->update($data);

            return response()->json([
                'success' => 1,
                'messages' => 'Data kebijakan privasi berhasil diupdate'
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
                'id' => 'required|exists:kebijakan_privasi,id'
            ]);

            $kebijakanPrivasi = KebijakanPrivasi::findOrFail($request->id);
            $kebijakanPrivasi->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data kebijakan privasi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}