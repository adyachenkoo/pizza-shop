<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function GetTopSellingProduct(string $category, Carbon $from, Carbon $to): Collection
    {
        return DB::table('order_product as op')
            ->join('orders as o', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->selectRaw('
                    SUM(op.quantity) as product_quantity,
                    p.name as product_name,
                    p.category_name as category
                ')
            ->where('p.category_name', $category)
            ->whereBetween('o.created_at', [$from, $to])
            ->groupBy('op.product_id', 'p.name', 'p.category_name')
            ->orderByDesc(DB::raw('SUM(op.quantity)'))
            ->limit(5)
            ->get();
    }
}
