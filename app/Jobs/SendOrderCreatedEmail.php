<?php

namespace App\Jobs;

use App\Models\Client;
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
    public function __construct(public $receiver)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->receiver instanceof Client) {
            $this->receiver->notify(new OrderCreatedNotification());
        } elseif ($this->receiver instanceof Seller) {
            $this->receiver->notify(new NewOrderNotification());
        }
    }
}
