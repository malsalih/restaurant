<?php

namespace App\Notifications;

use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderReceivedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        //
        // $menu_item=MenuItem::find($this->order->menu_item_id)->first();
        $this->order= $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $menu_item= MenuItem::where('id', $this->order->menu_item_id)->first();
        $name=$menu_item->name;

        
        return [
            //
            'bill_id'=> $this->order->bill_id,
            'menu_item_id'=> $this->order->menu_item_id,
            'count'=> $this->order->item_count,
            "name:"=>$name,  
            "type"=>"received_order"      
            // dd(json_last_error_msg()),

        ];
    }
}
