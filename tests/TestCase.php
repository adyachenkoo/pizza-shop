<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $seed = true;

    /**
     * @param $isAdmin
     * @return mixed
     */
    protected function getAuthToken($isAdmin)
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $isAdmin ? 'admin@example.com' : 'user@example.com',
            'password' => 'password'
        ]);

        return $response->json('access_token');
    }
}
