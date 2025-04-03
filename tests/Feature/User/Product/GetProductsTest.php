<?php

namespace tests\Feature\User\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_products()
    {

        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/user/product/');

        $response->assertOk();

        $response->assertJsonPath('result', true);

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
