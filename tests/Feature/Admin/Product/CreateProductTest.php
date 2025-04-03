<?php

namespace Tests\Feature\Admin\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('/api/admin/product/create', [
            'category_id' => 1,
            'name' => 'Новая пизза',
            'price' => 490,
            'description' => 'lalalala'
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
