<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatKantor extends Model
{
    use HasFactory;

    protected $table = 'alamat_kantor';

    protected $fillable = [
        'alamat',
        'no_telepon',
        'email',
        'link_maps',
        'created_by',
        'updated_by'
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