<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Ubah pemesanan_id menjadi nullable dan set null saat pemesanan dihapus
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanan')->onDelete('set null');
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak']);
            $table->string('alasan')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->string('kode_pemesanan')->nullable();
            $table->string('lapangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_bermain')->nullable();
            $table->decimal('idr', 8, 0)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
