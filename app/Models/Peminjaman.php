<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans'; 
    protected $primaryKey = 'id_peminjaman';
    
    protected $fillable = [
        'id_buku',
        'id_siswa',
        'id_petugas',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman'
    ];
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
    
    public function petugas()
    {
        return $this->belongsTo(PetugasPerpustakaan::class, 'id_petugas', 'id_petugas');
    }
    
    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_peminjaman', 'id_peminjaman');
    }
}