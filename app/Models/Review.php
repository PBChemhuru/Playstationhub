<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        
        'uuid',
        'comment',
        'rating',
        'verifiedPurchaser',
        'product_id'
    ];
}
