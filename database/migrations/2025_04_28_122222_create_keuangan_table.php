<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganTable extends Migration
{
    public function up()
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');             // Tanggal transaksi
            $table->string('bulan', 20);           // Format Nama bulan (contoh: April)
            $table->bigInteger('jumlah');         // Jumlah uang masuk
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangan');
    }
}
