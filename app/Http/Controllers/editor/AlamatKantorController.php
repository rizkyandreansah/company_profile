<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\AlamatKantor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlamatKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.editor.hubungikami.alamatkantor.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData(Request $request)
    {
        $data = AlamatKantor::select('alamat_kantor.*');
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $data->where(function($query) use ($search) {
                $query->where('alamat', 'like', '%' . $search . '%')
                      ->orWhere('no_telepon', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        return DataTables::of($data)
            ->addColumn('alamat_short', function($row) {
                return strlen($row->alamat) > 50 ? substr($row->alamat, 0, 50) . '...' : $row->alamat;
            })
            ->rawColumns(['alamat_short'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email',
            'link_maps' => 'nullable|url'
        ], [
            'alamat.required' => 'Alamat wajib diisi',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'link_maps.url' => 'Format link Google Maps tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            AlamatKantor::create([
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'link_maps' => $request->link_maps,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => 1,
                'messages' => 'Data alamat kantor berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail(Request $request)
    {
        try {
            $alamatKantor = AlamatKantor::find($request->id);
            
            if (!$alamatKantor) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'success' => 1,
                'data' => $alamatKantor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:alamat_kantor,id',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email',
            'link_maps' => 'nullable|url'
        ], [
            'alamat.required' => 'Alamat wajib diisi',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'link_maps.url' => 'Format link Google Maps tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            $alamatKantor = AlamatKantor::find($request->id);
            
            if (!$alamatKantor) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            $alamatKantor->update([
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'link_maps' => $request->link_maps,
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => 1,
                'messages' => 'Data alamat kantor berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteData(Request $request)
    {
        try {
            $alamatKantor = AlamatKantor::find($request->id);
            
            if (!$alamatKantor) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            $alamatKantor->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data alamat kantor berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}