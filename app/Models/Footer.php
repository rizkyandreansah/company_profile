<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $table = 'footer';

    protected $fillable = [
        'profil_singkat',
        'alamat_kantor',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Helper method untuk mengambil footer aktif
     */
    public static function getActiveFooter()
    {
        return self::where('is_active', 1)->first();
    }

    /**
     * Helper method untuk mengambil footer dengan fallback ke data default
     * Mengikuti pola yang sama dengan ProfilePerusahaan::getProfileWithDefault()
     */
    public static function getFooterWithDefault()
    {
        $footer = self::getActiveFooter();
        
        if (!$footer) {
            // Jika tidak ada data di database, return object dengan data default
            $footer = new self([
                'profil_singkat' => 'Profil Tidak Tersedia.',
                'alamat_kantor' => 'Alamat Tidak Tersedia',
                'is_active' => 1
            ]);
        }
        
        return $footer;
    }

    /**
     * Scope untuk filter footer aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}