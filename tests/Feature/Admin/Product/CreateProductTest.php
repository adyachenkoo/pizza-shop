<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product_by_user(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');

        $response = $this->post('/api/admin/product/create', [
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
