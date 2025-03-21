<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_petugas');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan', 'terlambat']);
            $table->timestamps();
            
            $table->foreign('id_buku')->references('id_buku')->on('bukus');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswas');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas_perpustakaans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
