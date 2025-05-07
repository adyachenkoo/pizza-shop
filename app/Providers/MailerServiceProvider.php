<?php

namespace App\Providers;

use App\Contracts\OrderMailerInterface;
use App\Services\Mailers\OrderMailer;
use Illuminate\Support\ServiceProvider;

class MailerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrderMailerInterface::class, OrderMailer::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
