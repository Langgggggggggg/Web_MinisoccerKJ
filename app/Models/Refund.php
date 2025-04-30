<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'alasan',
        'kode_pemesanan',
        'lapangan',
        'tanggal',
        'jam_bermain',
        'status',
        'bukti_transfer',
        'idr',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}

