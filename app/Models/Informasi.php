<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    // Tambahkan ini agar Laravel tahu nama tabel sebenarnya
    protected $table = 'informasi';

    protected $fillable = ['title', 'content', 'thumbnail', 'category', 'slug'];
}
