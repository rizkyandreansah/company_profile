<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebijakanPrivasi extends Model
{
    use HasFactory;

    protected $table = 'kebijakan_privasi';

    protected $fillable = [
        'judul',
        'content',
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
     * Helper method untuk mengambil kebijakan privasi aktif
     */
    public static function getActiveKebijakanPrivasi()
    {
        return self::where('is_active', 1)->first();
    }

    /**
     * Helper method untuk mengambil kebijakan privasi dengan fallback ke data default
     */
    public static function getKebijakanPrivasiWithDefault()
    {
        $kebijakanPrivasi = self::getActiveKebijakanPrivasi();
        
        if (!$kebijakanPrivasi) {
            // Jika tidak ada data di database, return object dengan data default
            $kebijakanPrivasi = new self([
                'judul' => 'Kebijakan Privasi',
                'content' => 'Konten kebijakan privasi tidak tersedia.',
                'is_active' => 1
            ]);
        }
        
        return $kebijakanPrivasi;
    }

    /**
     * Scope untuk filter kebijakan privasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}