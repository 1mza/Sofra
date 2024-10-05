<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $event->client->notify(new OrderCreatedNotification());
        $event->seller->notify(new NewOrderNotification());
    }
}
