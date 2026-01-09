<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();
  
        $table->foreignId('kontrak_sewa_id')->constrained('kontrak_sewa')->onDelete('cascade');
        
        $table->integer('bulan');
        $table->integer('tahun');
        $table->decimal('jumlah_bayar', 10, 2);
        $table->date('tanggal_bayar');
        $table->enum('status', ['lunas', 'tertunggak']);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
