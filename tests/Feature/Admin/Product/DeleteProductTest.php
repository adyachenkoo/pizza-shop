<?php

namespace Tests\Feature\Admin\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_product(): void
    {
        $token = $this->getAuthToken();

        $response = $this->delete('/api/admin/product/delete', [
            'product_id' => 5
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk();

        $response->assertJsonPath('result', true);
    }
}
