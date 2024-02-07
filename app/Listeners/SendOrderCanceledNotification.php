<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\OrderCanceledNotification;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notification;

class SendOrderCanceledNotification
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
        // ->where('workStart','<=',now()->format('H:i:s'))
        // ->where('workEnd','>=',now()->format('H:i:s'))

        ->where('category_id',$event->order->category_id)
        ->where('isActive',1)
        ->get();

        foreach ($chefs as $chef) {
            Notification::send($chef,new OrderCanceledNotification($event->order));
        }
    }
}
