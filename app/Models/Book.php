<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'year',
        'summary',
        'price',
       'cover_image' ,
        'promotion'
    ];

    protected $casts = [
        'promotion' => 'boolean',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

