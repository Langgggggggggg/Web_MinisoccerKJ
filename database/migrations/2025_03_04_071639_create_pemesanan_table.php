<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    public function up()
{
    Schema::create('pemesanan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Foreign key ke users
        $table->string('kode_pemesanan');
        $table->date('tanggal'); 
        $table->time('jam_mulai'); 
        $table->time('jam_selesai'); 
        $table->string('nama_tim');
        $table->string('no_telepon', 15);
        $table->decimal('dp', 8, 0)->nullable();
        $table->integer('harga'); 
        $table->enum('status', ['pending','lunas', 'belum lunas'])->nullable()->default(null);
        $table->integer('sisa_bayar')->nullable();
        $table->integer('lapangan');
        

        $table->timestamps();

        // Foreign key constraints
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->unique(['kode_pemesanan']);
    });
}



    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
}
