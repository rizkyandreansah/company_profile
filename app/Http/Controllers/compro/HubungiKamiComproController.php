<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\Controller;
use App\Models\AlamatKantor;
use App\Models\HubungiKami;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HubungiKamiComproController extends Controller
{
    public function index()
    {
        // Ambil data alamat kantor pertama yang tersedia
        $alamatKantor = AlamatKantor::select('alamat', 'no_telepon', 'email', 'link_maps')
                                   ->orderBy('created_at', 'desc')
                                   ->first();
        
        return view('pages.compro.hubungikami.index', compact('alamatKantor'));
    }

    /**
     * Method untuk mengambil data alamat kantor via AJAX
     */
    public function getData(): JsonResponse
    {
        try {
            // Ambil data alamat kantor untuk API
            $alamatKantor = AlamatKantor::select('id', 'alamat', 'no_telepon', 'email', 'link_maps')
                                       ->orderBy('created_at', 'desc')
                                       ->first();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'alamat_kantor' => $alamatKantor,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data alamat kantor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk submit form hubungi kami
     */
    public function submitForm(Request $request): JsonResponse
    {
        try {
            // Validasi data form
            $validator = Validator::make($request->all(), [
                'fullName' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'required|string|max:1000'
            ], [
                'fullName.required' => 'Nama lengkap wajib diisi',
                'fullName.max' => 'Nama lengkap maksimal 255 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.max' => 'Email maksimal 255 karakter',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.max' => 'Nomor telepon maksimal 20 karakter',
                'message.required' => 'Pesan wajib diisi',
                'message.max' => 'Pesan maksimal 1000 karakter'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Simpan data ke database (data akan terenkripsi otomatis melalui model)
            HubungiKami::create([
                'full_name' => $request->fullName,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'is_read' => false
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}