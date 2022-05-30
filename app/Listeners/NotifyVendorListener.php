<?php

namespace App\Listeners;

use Illuminate\Mail\Message;
use App\Events\OrderCompletedEvent;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyVendorListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->order;

        Mail::send('vendor', ['order' => $order], function(Message $message) use ($order) {
            $message->subject('Order has been completed');
            $message->to($order->vendor_email);
        });
    }
}
