<?php

namespace Tests\Feature\Admin\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_product(): void
    {
        $token = $this->getAuthToken(true);

        $response = $this->put('/api/admin/product/update/4', [
            'name' => 'name',
            'price' => 499,
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);

        $response->assertJsonStructure([
            'result',
            'data' => [
                'id',
                'category_id',
                'name',
                'price',
                'description'
            ]
        ]);
    }
}
