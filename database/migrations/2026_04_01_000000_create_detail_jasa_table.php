<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detail_jasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                  ->constrained('transaksis')
                  ->onDelete('cascade');
            $table->string('keterangan');
            $table->bigInteger('harga')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('detail_jasa');
    }
};
