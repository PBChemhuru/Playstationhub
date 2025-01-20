<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable =
    [
        'uuid',
        'item_details',
        'invoice_total',
    ];
}
