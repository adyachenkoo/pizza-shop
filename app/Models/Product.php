<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;

    protected $table = "products";

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
