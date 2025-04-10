<?php

namespace tests\Feature\User\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_products_by_guest()
    {
        $response = $this->getJson('/api/user/product/');

        $response->assertOk()->assertJsonPath('result', true);

        $response->assertJsonStructure([
            'result',
            'data' => [
                '*' => [
                    'id',
                    'category_id',
                    'name',
                    'price',
                    'description'
                ]
            ]
        ]);
    }
}
