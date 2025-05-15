<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'kode_pemesanan',
        'jadwal_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'nama_tim',
        'no_telepon',
        'dp',
        'harga',
        'status',
        'sisa_bayar',
    ];

    // Relasi ke jadwal (One to One)
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
