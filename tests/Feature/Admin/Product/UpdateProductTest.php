<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');
    }

    public function test_update_product_by_admin(): void
    {
        $response = $this->put('/api/admin/product/update/4', [
            'name' => 'name',
            'price' => 499,
        ]);

        $response->assertOk()->assertJsonPath('result', true);

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

    public function test_cant_update_product_without_data()
    {
        $response = $this->putJson('/api/admin/product/update/4');

        $response->assertStatus(422);
    }
}
