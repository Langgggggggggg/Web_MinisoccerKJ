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
        $table->unsignedBigInteger('jadwal_id'); // Foreign key ke jadwal
        $table->string('kode_pemesanan');
        $table->date('tanggal'); 
        $table->time('jam_mulai'); 
        $table->time('jam_selesai'); 
        $table->string('nama_tim');
        $table->string('no_telepon', 15);
        $table->decimal('dp', 8, 0)->nullable();
        $table->integer('harga'); 
        $table->enum('status', ['lunas', 'belum lunas'])->nullable()->default(null);
        $table->integer('sisa_bayar')->nullable();

        $table->timestamps();

        // Foreign key constraints
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade');
        $table->unique(['kode_pemesanan', 'jadwal_id']);
    });
}



    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
}
