<?php

namespace App\Http\Controllers\API\Admin\Report\Product;

use App\Services\ProductReportService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductReportController
{

    public function __construct(private readonly ProductReportService $productReportService)
    {

    }
    public function BestSellingPizzaOfMonthReport(string $year, string $month): JsonResponse
    {
        try {
            $result = $this->productReportService->GetTopSellingProductOfMonth(
                'pizza',
                Carbon::create($year, $month)->startOfMonth(),
                Carbon::create($year, $month)->endOfMonth()
            );

            return response()->json([
                'result' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            logger()->error('Возникла ошибка при создании отчета: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'result' => false,
                'error' => 'Ошибка сервера при создании отчета',
            ], 500);
        }
    }
}
