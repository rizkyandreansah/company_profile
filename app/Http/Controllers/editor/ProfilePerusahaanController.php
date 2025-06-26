<?php

namespace App\Http\Controllers\editor;

use Exception;
use App\Models\ProfilePerusahaan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ProfilePerusahaanController extends Controller
{
    public function index()
    {
        return view('pages.editor.tentangkami.profilperusahaan.index');
    }

    public function getData(Request $request): JsonResponse
    {
        $rescode = 200;
        
        try {
            // Ambil parameter DataTables
            $draw = $request->input('draw', 1);
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            
            // Ambil parameter pencarian
            $searchValue = '';
            if ($request->has('search') && is_array($request->search)) {
                $searchValue = $request->search['value'] ?? '';
            } elseif ($request->has('search') && is_callable($request->search)) {
                $searchValue = call_user_func($request->search);
            } else {
                $searchValue = $request->input('search', '');
            }

            // Query builder
            $query = ProfilePerusahaan::query();
            
            // Jika ada pencarian
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('isi_singkat_profil', 'LIKE', '%'.$searchValue.'%')
                      ->orWhere('visi', 'LIKE', '%'.$searchValue.'%')
                      ->orWhere('misi', 'LIKE', '%'.$searchValue.'%');
                });
            }
            
            // Hitung total record sebelum filter
            $totalRecords = ProfilePerusahaan::count();
            
            // Hitung total record setelah filter
            $totalFiltered = $query->count();
            
            // Ambil data dengan pagination
            $profilePerusahaan = $query->orderBy('created_at', 'desc')
                          ->offset($start)
                          ->limit($length)
                          ->get();

            // Format response sesuai DataTables
            $data = [
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $profilePerusahaan->toArray()
            ];
            
        } catch (QueryException $e) {
            Log::error('QueryException in ProfilePerusahaanController@getData: ' . $e->getMessage());
            $data = [
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Ops terjadi kesalahan saat mengambil data'
            ];
            $rescode = 500;
        } catch (Exception $e) {
            Log::error('Exception in ProfilePerusahaanController@getData: ' . $e->getMessage());
            $data = [
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Ops terjadi kesalahan pada server'
            ];
            $rescode = 500;
        }

        return response()->json($data, $rescode);
    }

    public function storeData(Request $request): JsonResponse
    {
        date_default_timezone_set('Asia/Jakarta');
        $rescode = 200;
        $user = Auth::user()->id;
        try {
            $rules = [
                'isi_singkat_profil' => 'required|max:100',
                'isi_lengkap_profil' => 'required|',
                'visi' => 'required|',
                'misi' => 'required|',
                'is_active' => 'required|boolean',
            ];
            $messages = [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus bertipe string',
                'max' => ':attribute tidak boleh lebih dari :max karakter',
                'boolean' => ':attribute harus berupa true atau false',
            ];
            $data = $request->all();
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $v_error = $validator->errors()->all();
                $res = ['success' => 0, 'messages' => implode(', ', $v_error)];
            } else {
                $validData = $validator->validate();
                $validData['created_by'] = $user;
                $in = ProfilePerusahaan::create($validData);
                $res = ['success' => 1, 'messages' => 'Success Tambah Data Profile Perusahaan'];
            }
        } catch (QueryException $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan saat Proses data'];
            Log::error('QueryException: '.$e);
        } catch (Exception $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan pada server'];
            Log::error('Exception: '.$e);
        }

        return response()->json($res, $rescode);
    }

    public function detail(Request $request): JsonResponse
    {
        $rescode = 200;
        $id = $request->input('id', 0);
        $data = ProfilePerusahaan::find($id);
        $res = [];
        if ($data) {
            $res = ['success' => 1, 'data' => $data];
        } else {
            $res = ['success' => 0, 'messages' => 'Data tidak ditemukan'];
        }

        return response()->json($res, $rescode);
    }

    public function updateData(Request $request): JsonResponse
    {
        date_default_timezone_set('Asia/Jakarta');
        $rescode = 200;
        $user = Auth::user()->id;
        $id = $request->input('id', 0);
        try {
            $rules = [
                'isi_singkat_profil' => 'required|string|max:500',
                'isi_lengkap_profil' => 'required|string',
                'visi' => 'required|string',
                'misi' => 'required|string',
                'is_active' => 'required|boolean',
            ];
            $messages = [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus bertipe string',
                'max' => ':attribute tidak boleh lebih dari :max karakter',
                'boolean' => ':attribute harus berupa true atau false',
            ];
            $data = $request->all();
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $v_error = $validator->errors()->all();
                $res = ['success' => 0, 'messages' => implode(', ', $v_error)];
            } else {
                $validData = $validator->validate();
                $profilePerusahaan = ProfilePerusahaan::find($id);
                if ($profilePerusahaan) {
                    $validData['updated_by'] = $user;
                    $profilePerusahaan->update($validData);
                    $res = ['success' => 1, 'messages' => 'Success Update Data Profile Perusahaan'];
                } else {
                    $res = ['success' => 0, 'messages' => 'Data tidak ditemukan'];
                }
            }
        } catch (QueryException $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan saat update data'];
            Log::error('QueryException: '.$e);
        } catch (Exception $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan pada server'];
            Log::error('Exception: '.$e);
        }

        return response()->json($res, $rescode);
    }

    public function deleteData(Request $request): JsonResponse
    {
        date_default_timezone_set('Asia/Jakarta');
        $rescode = 200;
        $id = $request->input('id');
        try {
            $profilePerusahaan = ProfilePerusahaan::find($id);
            $res = [];
            if ($profilePerusahaan) {
                $profilePerusahaan->delete();
                $res = ['success' => 1, 'messages' => 'Success Delete Data Profile Perusahaan'];
            } else {
                $res = ['success' => 0, 'messages' => 'Data tidak ditemukan'];
            }
        } catch (QueryException $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan saat hapus data'];
            Log::error('QueryException: '.$e->getMessage());
        } catch (Exception $e) {
            $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan pada server '.$e];
            Log::error('Exception: '.$e->getMessage());
        }

        return response()->json($res, $rescode);
    }
}