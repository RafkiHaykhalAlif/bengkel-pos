<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 30)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['eceran', 'grosir', 'servis']);
            $table->enum('metode_bayar', ['Cash', 'QRIS']);
            $table->bigInteger('total')->default(0);
            $table->enum('status', ['selesai', 'diretur'])->default('selesai');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksis');
    }
};