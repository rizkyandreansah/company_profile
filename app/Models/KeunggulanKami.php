<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class KeunggulanKami extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keunggulan_kami';

    protected $fillable = [
        'gambar_ikon',
        'judul',
        'deskripsi',
        'is_active',
        'urutan',
        'created_by',
        'update_by',
        'delete_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Accessor untuk URL gambar ikon
    public function getGambarIkonUrlAttribute()
    {
        if ($this->gambar_ikon) {
            return Storage::url($this->gambar_ikon);
        }
        return null;
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('created_at', 'desc');
    }

    // Boot method untuk handle file deletion
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // Delete file when model is deleted
            if ($model->gambar_ikon && Storage::exists($model->gambar_ikon)) {
                Storage::delete($model->gambar_ikon);
            }
        });
    }
}