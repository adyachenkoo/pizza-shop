<?php

namespace App\Services\Mailers;

use App\Contracts\OrderMailerInterface;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderMailer implements OrderMailerInterface
{
    public function sendOrderCreated(Order $order): void
    {
        $user = $order->user;
        if ($user && $user->email) {
            Mail::to($user->email)->send(new OrderCreatedMail($order));
        }
    }
}
