<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Jobs\SendOrderCreatedEmail;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderEmailListener
{
//    use InteractsWithQueue;
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
        SendOrderCreatedEmail::dispatch($event->client)->afterCommit();
        SendOrderCreatedEmail::dispatch($event->seller)->afterCommit();
//        $event->client->notify(new OrderCreatedNotification());
//        $event->seller->notify(new NewOrderNotification());
    }
}
