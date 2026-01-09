<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
{
    Schema::create('penyewa', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap', 100);
        $table->string('nomor_telepon', 15);
        $table->string('nomor_ktp', 20)->unique();
        $table->text('alamat_asal');
        $table->string('pekerjaan', 50);
        $table->timestamps();
    });
}

  
    public function down(): void
    {
        Schema::dropIfExists('penyewa');
    }
};
