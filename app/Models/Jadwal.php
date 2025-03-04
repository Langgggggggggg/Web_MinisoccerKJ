<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemesanan;
class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'tanggal',
        'jam',
        'lapangan',
    ];

    // Relasi ke pemesanan (One to One)
    public function pemesanan()
    {
        return $this->hasOne(Pemesanan::class, 'jadwal_id');
    }
}
