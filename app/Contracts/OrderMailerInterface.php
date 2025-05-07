<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderMailerInterface
{
    public function sendOrderCreated(Order $order): void;
}
