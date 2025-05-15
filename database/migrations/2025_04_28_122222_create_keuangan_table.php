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
            $table->unsignedBigInteger('pemesanan_id'); // foreign key ke tabel pemesanan
            $table->date('tanggal');
            $table->string('bulan', 20);
            $table->bigInteger('jumlah');
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('keuangan');
    }
}
