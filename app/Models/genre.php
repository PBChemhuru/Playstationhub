<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    //use HasFactory; 

    protected $fillable = [
        
        'genre',
    ];

    public $timestamps = false;
}
