<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\Controller;
use App\Models\KebijakanPrivasi;
use Illuminate\Http\Request;

class KebijakanPrivasiComproController extends Controller
{
    public function index()
    {
        try {
            // Ambil kebijakan privasi yang aktif dengan limit 10, urutkan berdasarkan created_at terbaru
            $kebijakanPrivasiList = KebijakanPrivasi::where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

            return view('pages.compro.kebijakanprivasi.index', compact('kebijakanPrivasiList'));
            
        } catch (\Exception $e) {
            // Jika terjadi error, inisialisasi sebagai collection kosong
            $kebijakanPrivasiList = collect();
            return view('pages.compro.kebijakanprivasi.index', compact('kebijakanPrivasiList'));
        }
    }

    /**
     * Method untuk mengambil data via AJAX (opsional untuk keperluan lain)
     */
    public function getData()
    {
        try {
            // Ambil kebijakan privasi yang aktif dengan limit 10
            $kebijakanPrivasiList = KebijakanPrivasi::where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get(['judul', 'content']);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'kebijakan_privasi' => $kebijakanPrivasiList
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data kebijakan privasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}