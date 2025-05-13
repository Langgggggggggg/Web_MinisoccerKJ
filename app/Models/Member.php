<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_berakhir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
