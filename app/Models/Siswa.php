<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_siswa';
    
    protected $fillable = [
        'nisn_siswa',
        'nama_siswa',
        'kelas',
        'alamat_siswa',
        'nomor_telepon',
        'email_siswa'
    ];
    
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_siswa', 'id_siswa');
    }
}