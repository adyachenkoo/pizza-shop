<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orderProducts')
            ->withPivot('quantity');
    }
}
