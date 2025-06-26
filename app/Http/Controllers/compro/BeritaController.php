<?php

namespace App\Http\Controllers\compro;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        // Ambil maksimal 3 berita yang aktif, diurutkan berdasarkan tanggal publish terbaru
        $news = News::select('id', 'judul', 'isiberita', 'image', 'tanggal_publish')
                   ->where('is_active', true)
                   ->orderBy('tanggal_publish', 'desc')
                   ->limit(2)
                   ->get();
        
        return view('pages.compro.berita.index', compact('news'));
    }

    public function getData():JsonResponse
    {
        // Ambil semua berita yang aktif, diurutkan berdasarkan tanggal publish terbaru
        $news = News::select('id', 'judul', 'isiberita', 'image', 'tanggal_publish')
                   ->where('is_active', true)
                   ->orderBy('tanggal_publish', 'desc')
                   ->get();
        
        $data = [
            'news' => $news,
        ];
        return response()->json($data);
    }
}