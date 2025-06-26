<?php

namespace App\Http\Controllers\compro;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterComproController extends Controller
{
    public function index()
    {
        // Mengambil data footer aktif, jika tidak ada maka menggunakan data default
        $footer = Footer::getFooterWithDefault();

        return view('includes.compro.footer', compact('footer'));
    }

    /**
     * Method untuk mengambil data footer via AJAX
     */
    public function getData()
    {
        try {
            $footer = Footer::getFooterWithDefault();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $footer->id ?? null,
                    'profil_singkat' => $footer->profil_singkat,
                    'alamat_kantor' => $footer->alamat_kantor,
                    'is_active' => $footer->is_active ?? 1,
                    'created_at' => $footer->created_at ?? null,
                    'updated_at' => $footer->updated_at ?? null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}