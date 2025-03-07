<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'status_id',
        'user_id',
        'address',
        'phoneNumber',
        'deliveryTime',
        'email',
        'totalPrice',
        'comment',
    ];
}
