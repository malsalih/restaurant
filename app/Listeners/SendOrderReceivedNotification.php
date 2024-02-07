<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\OrderReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notification;


class SendOrderReceivedNotification
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
    public function handle(object $event): void
    {
        //
        $chefs=User::where('user_type_id',4)
        ->where('category_id',$event->order->category_id)
        // ->where('workStart','<=',now()->format('H:i:s'))
        // ->where('workEnd','>=',now()->format('H:i:s'))
        ->where('isActive',1)
        ->get();
        foreach ($chefs as $chef) {
            Notification::send($chef,new OrderReceivedNotification($event->order));
        }
    }
}
