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
    Schema::create('dendas', function (Blueprint $table) {
        $table->id('id_denda');
        $table->unsignedBigInteger('id_peminjaman');
        $table->decimal('jumlah_denda_perhari', 10, 2);
        $table->decimal('denda_hilang', 10, 2)->nullable();
        $table->decimal('total_denda_keseluruhan', 10, 2);
        $table->enum('status_pembayaran', ['lunas', 'belum_lunas']);
        $table->date('tanggal_pembayaran')->nullable();
        $table->timestamps();
        
        $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjamans');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
