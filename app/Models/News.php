<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';
    
    protected $fillable = [
        'judul',
        'isiberita',
        'image',
        'tanggal_publish',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
        'is_active' => 'boolean'
    ];

    protected $dates = ['deleted_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}