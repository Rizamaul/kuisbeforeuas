<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
{
    Schema::create('kamar', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_kamar', 10)->unique(); // A1, B2
        $table->enum('tipe', ['standard', 'deluxe', 'vip']);
        $table->decimal('harga_bulanan', 10, 2);
        $table->text('fasilitas'); // AC, WiFi
        $table->enum('status', ['tersedia', 'terisi'])->default('tersedia');
        $table->timestamps();
    });
}

  
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
