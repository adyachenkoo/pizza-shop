<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = "orderStatuses";

    protected $fillable = [
        'name'
    ];
}
