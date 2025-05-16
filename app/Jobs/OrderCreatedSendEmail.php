<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\Mailers\OrderMailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderCreatedSendEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
        //
    }

    public function handle(OrderMailer $mailer): void
    {
        $mailer->sendOrderCreated($this->order);
    }
}
