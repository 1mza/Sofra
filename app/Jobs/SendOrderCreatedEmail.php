<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Seller;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Client $client , public Seller $seller , public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->client->notify(new OrderCreatedNotification());
        $notification = Notification::create([
            'client_id' => $this->client->id,
            'order_id' => $this->order->id,
            'title' => 'Your order has been placed',
            'content' => 'your order has been placed',
        ]);
        logger($notification);
        $this->seller->notify(new NewOrderNotification());
    }
}
