<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanding extends Model
{
    protected $table = 'tanding';
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'whatsapp_number',
        'location_active',
        'logo_tim',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
