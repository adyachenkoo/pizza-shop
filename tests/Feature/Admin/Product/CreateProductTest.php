<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');
    }

    public function test_create_product_by_user(): void
    {
        $response = $this->post('/api/admin/product/create', [
            'category_id' => 1,
            'name' => 'Новая пизза',
            'price' => 490,
            'description' => 'lalalala'
        ]);

        $response->assertOk()->assertJsonPath('result', true);

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

    public function test_cant_create_product_without_data()
    {
        $response = $this->postJson('/api/admin/product/create');

        $response->assertStatus(422);
    }
}
