<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_denda';
    
    protected $fillable = [
        'id_peminjaman',
        'jumlah_denda_perhari',
        'denda_hilang',
        'total_denda_keseluruhan',
        'status_pembayaran',
        'tanggal_pembayaran'
    ];
    
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}