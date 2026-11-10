<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'name',
        'price',
        'availability',
        'rent_date',
        'image',
        'rent_type',
    ];

    protected $dates = ['rent_date'];
    protected $casts = ['rent_date' => 'date'];
}
