<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'image',
        'judul',
        'penerbit',
        'tanggal_terbit',
        'deskripsi',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
    'tanggal_terbit' => 'date',
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

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}