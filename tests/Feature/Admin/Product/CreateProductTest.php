<?php

namespace Tests\Feature\Admin\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product(): void
    {
        $token = $this->getAuthToken(true);

        $response = $this->post('/api/admin/product/create', [
            'category_id' => 1,
            'name' => 'Новая пизза',
            'price' => 490,
            'description' => 'lalalala'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);

        $response->assertJsonStructure([
            'result',
            'data' => [
                'category_id',
                'name',
                'price',
                'description',
            ]
        ]);
    }
}
