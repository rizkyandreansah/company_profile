<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class HubungiKami extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hubungi_kami';

    protected $fillable = [
        'full_name',
        'email', 
        'phone',
        'message',
        'is_read',
        'deleted_by'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Mutator untuk enkripsi saat menyimpan
    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = Crypt::encryptString($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encryptString($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = Crypt::encryptString($value);
    }

    // Accessor untuk dekripsi saat mengambil data
    public function getFullNameAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Return original value if decryption fails
        }
    }

    public function getEmailAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Return original value if decryption fails
        }
    }

    public function getPhoneAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Return original value if decryption fails
        }
    }

    // Relasi dengan User (yang menghapus)
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Scope untuk pesan yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk pesan yang sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Method untuk menandai sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Method untuk menandai sebagai belum dibaca
    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }
}