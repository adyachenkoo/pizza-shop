<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductReportService
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }
    public function GetTopSellingProductOfMonth(string $category, Carbon $from, Carbon $to): Collection
    {
        $cacheKey = "top_selling_{$category}_{$from->format('Ymd_His')}_{$to->format('Ymd_His')}";

        return Cache::remember($cacheKey, 50, function () use ($category, $from, $to) {
            return $this->productRepository->GetTopSellingProduct($category, $from, $to);
        });
    }
}
