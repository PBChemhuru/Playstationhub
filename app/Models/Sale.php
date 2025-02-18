<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $fillable = [
        'name',
        'game_id',
        'old_price',
        'new_price',
        'image',
    ];

    public $timestamps = false;
}
