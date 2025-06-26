<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePerusahaan extends Model
{
    use HasFactory;

    protected $table = 'profile_perusahaan';
    
    protected $fillable = [
        'isi_singkat_profil',
        'isi_lengkap_profil',
        'visi',
        'misi',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method statis untuk mendapatkan profile aktif terbaru
    public static function getActiveProfile()
    {
        return self::active()
            ->orderBy('created_at', 'desc')
            ->first();
    }

    // Method untuk mendapatkan data dengan fallback default
    public static function getProfileWithDefault()
    {
        $profile = self::getActiveProfile();
        
        if (!$profile) {
            return (object) [
                'isi_singkat_profil' => 'Profil singkat perusahaan belum diatur.',
                'isi_lengkap_profil' => 'Profil lengkap perusahaan belum diatur.',
                'visi' => 'Visi perusahaan belum diatur.',
                'misi' => 'Misi perusahaan belum diatur.'
            ];
        }
        
        return $profile;
    }
}