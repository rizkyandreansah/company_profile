<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\Controller;
use App\Models\LayananKami;
use Illuminate\Http\Request;

class LayananComproController extends Controller
{
    public function index()
    {
        // Ambil headline dari data yang terbaru (latest)
        $headline = LayananKami::where('is_active', 1)
            ->latest('created_at')
            ->value('headline');

        // Ambil semua layanan yang aktif
        $layananList = LayananKami::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get(['judul_layanan', 'deskripsi_layanan']);

        return view('pages.compro.layanan.index', compact('headline', 'layananList'));
    }

    /**
     * Method untuk mengambil data via AJAX (opsional untuk keperluan lain)
     */
    public function getData()
    {
        try {
            // Ambil headline dari data yang terbaru (latest)
            $headline = LayananKami::where('is_active', 1)
                ->latest('created_at')
                ->value('headline');

            // Ambil semua layanan yang aktif
            $layananList = LayananKami::where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->get(['judul_layanan', 'deskripsi_layanan']);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'headline' => $headline,
                    'layanan' => $layananList
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}