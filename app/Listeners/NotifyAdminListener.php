<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Message;
use Mail;

class NotifyAdminListener
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

        Mail::send('admin', ['order' => $order], function(Message $message) {
            $message->subject('Order has been completed');
            $message->to('sibalonat@gmail.com');
        });
    }
}
