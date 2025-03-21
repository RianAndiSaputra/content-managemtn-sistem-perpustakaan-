<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_buku';
    
    protected $fillable = [
        'judul_buku',
        'penulis_buku',
        'penerbit_buku',
        'tahun_terbit',
        'isbn_buku',
        'kategori_buku',
        'jumlah_buku_tersedia'
    ];
    
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }
}