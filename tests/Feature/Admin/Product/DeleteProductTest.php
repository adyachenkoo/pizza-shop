<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_product_by_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user, 'api');

        $response = $this->delete('/api/admin/product/delete', [
            'product_id' => 5
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);
    }
}
