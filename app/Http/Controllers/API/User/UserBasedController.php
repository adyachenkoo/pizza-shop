<?php

namespace App\Http\Controllers\API\User;

use App\Models\User;

class UserBasedController
{
    /**
     * Получение  юзера
     *
     * @return User
     */
    public function getUser(): User
    {
        if (!auth('jwt')->check()) {
            throw new \RuntimeException('User not authenticated');
        }

        return auth()->user();
    }
}
