<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'type',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

