<?php

namespace App\Http\Controllers\compro;

use App\Http\Controllers\Controller;
use App\Models\MasterHead;
use App\Models\KeunggulanKami;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeComproController extends Controller
{
    public function index()
    {
        return view('pages.compro.home.index');
    }

    public function getData(): JsonResponse
    {
        try {
            // Ambil data master head
            $masterHead = MasterHead::select('title', 'subtitle', 'image')->latest()->first();
            
            // Ambil data keunggulan kami yang aktif dan diurutkan
            $keunggulanKami = KeunggulanKami::where('is_active', 1)
                ->orderBy('urutan', 'asc')
                ->orderBy('created_at', 'asc')
                ->select('id', 'gambar_ikon', 'judul', 'deskripsi')
                ->get();
            
            // Transform data keunggulan kami untuk response
            $keunggulanKami = $keunggulanKami->map(function ($item) {
                return [
                    'id' => $item->id,
                    'gambar_ikon' => $item->gambar_ikon ? asset('storage/' . $item->gambar_ikon) : null,
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi
                ];
            });
            
            $data = [
                'master_head' => $masterHead,
                'keunggulan_kami' => $keunggulanKami,
            ];
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}