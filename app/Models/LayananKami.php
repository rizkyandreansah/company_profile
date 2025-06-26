<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananKami extends Model
{
    use HasFactory;

    protected $table = 'layanan_kami';

    protected $fillable = [
        'headline',
        'judul_layanan',
        'deskripsi_layanan',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with User for created_by
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with User for updated_by
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
