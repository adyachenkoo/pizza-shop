<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_product_by_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');

        $response = $this->put('/api/admin/product/update/4', [
            'name' => 'name',
            'price' => 499,
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
