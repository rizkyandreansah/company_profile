<?php

namespace App\Http\Controllers\compro;

use App\Http\Controllers\Controller;
use App\Models\ProfilePerusahaan;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class TentangKamiComproController extends Controller
{
    public function index()
    {
        // Menggunakan helper method dari model
        $profilePerusahaan = ProfilePerusahaan::getProfileWithDefault();
        
        // Mengambil data sertifikat aktif, diurutkan berdasarkan tanggal terbit terbaru
        $sertifikat = Sertifikat::where('is_active', 1)
                                ->orderBy('tanggal_terbit', 'desc')
                                ->get();

        return view('pages.compro.about.index', compact('profilePerusahaan', 'sertifikat'));
    }

    /**
     * Method untuk mengambil data via AJAX (opsional)
     */
    public function getData()
    {
        try {
            $profilePerusahaan = ProfilePerusahaan::getActiveProfile();

            if (!$profilePerusahaan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data profile perusahaan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $profilePerusahaan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk mengambil data sertifikat via AJAX
     */
    public function getSertifikatData()
    {
        try {
            $sertifikat = Sertifikat::where('is_active', 1)
                                   ->orderBy('tanggal_terbit', 'desc')
                                   ->get();

            return response()->json([
                'status' => 'success',
                'data' => $sertifikat->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'penerbit' => $item->penerbit,
                        'tanggal_terbit' => $item->tanggal_terbit->format('d F Y'),
                        'deskripsi' => $item->deskripsi,
                        'image_url' => $item->image_url,
                        'image' => $item->image
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}