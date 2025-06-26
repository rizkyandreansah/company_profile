<?php

namespace App\Http\Controllers\editor;

use Exception;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        return view('pages.editor.news.index');
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
            $query = News::query();
            
            // Jika ada pencarian
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('judul', 'LIKE', '%'.$searchValue.'%')
                      ->orWhere('isiberita', 'LIKE', '%'.$searchValue.'%');
                });
            }
            
            // Hitung total record sebelum filter
            $totalRecords = News::count();
            
            // Hitung total record setelah filter
            $totalFiltered = $query->count();
            
            // Ambil data dengan pagination
            $news = $query->orderBy('tanggal_publish', 'desc')
                         ->offset($start)
                         ->limit($length)
                         ->get();

            // Format response sesuai DataTables
            $data = [
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $news->toArray()
            ];
            
        } catch (QueryException $e) {
            Log::error('QueryException in NewsController@getData: ' . $e->getMessage());
            $data = [
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Ops terjadi kesalahan saat mengambil data'
            ];
            $rescode = 500;
        } catch (Exception $e) {
            Log::error('Exception in NewsController@getData: ' . $e->getMessage());
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
                'judul' => 'required|string|max:255',
                'isiberita' => 'required|',
                'tanggal_publish' => 'required|date',
                'is_active' => 'required|boolean',
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $messages = [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus bertipe string',
                'max' => ':attribute tidak boleh lebih dari :max karakter',
                'date' => ':attribute harus berupa tanggal yang valid',
                'boolean' => ':attribute harus berupa true atau false',
                'file.image' => ':attribute tipe file harus gambar',
                'file.mimes' => ':attribute tipe gambar hanya boleh jpeg, png, jpg',
                'file.max' => ':attribute ukuran tidak boleh lebih dari 2MB',
            ];
            $data = $request->all();
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $v_error = $validator->errors()->all();
                $res = ['success' => 0, 'messages' => implode(', ', $v_error)];
            } else {
                $validData = $validator->validate();
                $img = $validData['file'];
                $file_name = Str::uuid().'.'.$img->getClientOriginalExtension();
                $path = $img->storeAs('img/news', $file_name, 'public');
                $validData['created_by'] = $user;
                $validData['image'] = $path;
                unset($validData['file']);
                $in = News::create($validData);
                $res = ['success' => 1, 'messages' => 'Success Tambah Data Berita'];
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
        $data = News::find($id);
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
            if (!$request->filled('file')) {
                $request->merge(['file' => null]);
            }
            $rules = [
                'judul' => 'required|string|max:255',
                'isiberita' => 'required|string',
                'tanggal_publish' => 'required|date',
                'is_active' => 'required|boolean',
                'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
            $messages = [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus bertipe string',
                'max' => ':attribute tidak boleh lebih dari :max karakter',
                'date' => ':attribute harus berupa tanggal yang valid',
                'boolean' => ':attribute harus berupa true atau false',
                'file.image' => ':attribute tipe file harus gambar',
                'file.mimes' => ':attribute tipe gambar hanya boleh jpeg, png, jpg',
                'file.max' => ':attribute ukuran tidak boleh lebih dari 2MB',
            ];
            $data = $request->all();
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $v_error = $validator->errors()->all();
                $res = ['success' => 0, 'messages' => implode(', ', $v_error)];
            } else {
                $validData = $validator->validate();
                $news = News::find($id);
                if ($news) {
                    if($validData['file'] != null){
                        $filePath = $news['image'];
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                        $img = $validData['file'];
                        $file_name = Str::uuid().'.'.$img->getClientOriginalExtension();
                        $path = $img->storeAs('img/news', $file_name, 'public');
                        $validData['image'] = $path;
                    }
                    $validData['updated_by'] = $user;
                    unset($validData['file']);
                    $news->update($validData);
                    $res = ['success' => 1, 'messages' => 'Success Update Data Berita'];
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
    $user = Auth::user()->id;
    
    try {
        $news = News::find($id);
        $res = [];
        
        if ($news) {
            // Hapus file gambar dari storage sebelum hapus data
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                $deleteResult = Storage::disk('public')->delete($news->image);
                // Log jika penghapusan file gagal (optional)
                if (!$deleteResult) {
                    Log::warning('Failed to delete image file: ' . $news->image . ' for news ID: ' . $id);
                }
            }
            
            // Update deleted_by dan hapus data
            $news->update(['deleted_by' => $user]);
            $news->delete();
            
            $res = ['success' => 1, 'messages' => 'Success Delete Data Berita'];
        } else {
            $res = ['success' => 0, 'messages' => 'Data tidak ditemukan'];
        }
        
    } catch (QueryException $e) {
        $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan saat hapus data'];
        Log::error('QueryException in deleteData: ' . $e->getMessage());
    } catch (Exception $e) {
        $res = ['success' => 0, 'messages' => 'Ops terjadi kesalahan pada server'];
        Log::error('Exception in deleteData: ' . $e->getMessage());
    }

    return response()->json($res, $rescode);
}
}