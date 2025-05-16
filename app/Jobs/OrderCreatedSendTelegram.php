<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderCreatedSendTelegram implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function handle(): void
    {
        $chatId = config('telegram.chat_id');

        $message = "Создан новый заказ:\nАдрес:{$this->order->address}\nEmail:{$this->order->email}\nСумма заказа:{$this->order->totalPrice}\nКомментарий:{$this->order->comment}";

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
