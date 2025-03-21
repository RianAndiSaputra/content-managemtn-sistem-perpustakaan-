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
    Schema::create('siswas', function (Blueprint $table) {
        $table->id('id_siswa');
        $table->string('nisn_siswa')->unique();
        $table->string('nama_siswa');
        $table->string('kelas');
        $table->text('alamat_siswa');
        $table->string('nomor_telepon');
        $table->string('email_siswa')->unique();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
