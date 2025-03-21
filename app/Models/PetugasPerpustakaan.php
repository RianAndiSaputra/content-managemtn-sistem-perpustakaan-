<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasPerpustakaan extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_petugas';
    
    protected $fillable = [
        'nama_petugas',
        'username_petugas',
        'password_petugas',
        'email_petugas'
    ];
    
    protected $hidden = [
        'password_petugas'
    ];
    
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_petugas', 'id_petugas');
    }
}