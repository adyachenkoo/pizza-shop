<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
