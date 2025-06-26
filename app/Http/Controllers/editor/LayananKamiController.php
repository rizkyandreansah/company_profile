<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\LayananKami;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LayananKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.editor.Layanan.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData(Request $request)
    {
        $data = LayananKami::select('layanan_kami.*');
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $data->where(function($query) use ($search) {
                $query->where('headline', 'like', '%' . $search . '%')
                      ->orWhere('judul_layanan', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi_layanan', 'like', '%' . $search . '%');
            });
        }

        return DataTables::of($data)
            ->addColumn('status', function($row) {
                return $row->is_active ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'headline' => 'required|string|max:300',
            'judul_layanan' => 'required|string|max:300',
            'deskripsi_layanan' => 'required|string',
            'is_active' => 'required|boolean'
        ], [
            'headline.required' => 'Headline wajib diisi',
            'headline.max' => 'Headline maksimal 300 karakter',
            'judul_layanan.required' => 'Judul layanan wajib diisi',
            'judul_layanan.max' => 'Judul layanan maksimal 300 karakter',
            'deskripsi_layanan.required' => 'Deskripsi layanan wajib diisi',
            'is_active.required' => 'Status wajib dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            LayananKami::create([
                'headline' => $request->headline,
                'judul_layanan' => $request->judul_layanan,
                'deskripsi_layanan' => $request->deskripsi_layanan,
                'is_active' => $request->is_active,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => 1,
                'messages' => 'Data layanan berhasil ditambahkan'
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
            $layanan = LayananKami::find($request->id);
            
            if (!$layanan) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'success' => 1,
                'data' => $layanan
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
            'id' => 'required|exists:layanan_kami,id',
            'headline' => 'required|string|max:300',
            'judul_layanan' => 'required|string|max:300',
            'deskripsi_layanan' => 'required|string',
            'is_active' => 'required|boolean'
        ], [
            'headline.required' => 'Headline wajib diisi',
            'headline.max' => 'Headline maksimal 300 karakter',
            'judul_layanan.required' => 'Judul layanan wajib diisi',
            'judul_layanan.max' => 'Judul layanan maksimal 300 karakter',
            'deskripsi_layanan.required' => 'Deskripsi layanan wajib diisi',
            'is_active.required' => 'Status wajib dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'messages' => $validator->errors()->first()
            ]);
        }

        try {
            $layanan = LayananKami::find($request->id);
            
            if (!$layanan) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            $layanan->update([
                'headline' => $request->headline,
                'judul_layanan' => $request->judul_layanan,
                'deskripsi_layanan' => $request->deskripsi_layanan,
                'is_active' => $request->is_active,
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => 1,
                'messages' => 'Data layanan berhasil diperbarui'
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
            $layanan = LayananKami::find($request->id);
            
            if (!$layanan) {
                return response()->json([
                    'success' => 0,
                    'messages' => 'Data tidak ditemukan'
                ]);
            }

            $layanan->delete();

            return response()->json([
                'success' => 1,
                'messages' => 'Data layanan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}