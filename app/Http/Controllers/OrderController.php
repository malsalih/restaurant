<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemResource;
use App\Http\Resources\OrderResource;
use App\Mail\OrderReceived;
use App\Models\Bill;
use App\Models\MenuItem;
use App\Models\Notification;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $menuItems = MenuItem::all();
        // return (MenuItemResource::collection($menuItems));
        $menuItems = Order::with('menu_item.category','order_type')->get();
        return (OrderResource::collection($menuItems));

        // return ($menuItems);
    }

    public function index_by_user()
    {

        $menuItems = Order::with('menu_item.category','order_type')
        ->where('category_id',Auth::user()->category_id)->get();
        return (OrderResource::collection($menuItems));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreOrderRequest $request,array $orderIds)
    public function store(StoreOrderRequest $request)

    {

        //get items 
        $itemIds=$request->itemIds;

        $bill=Bill::create([ ]);
        
        $item_num=0;

        $sum_normal_price=0;
        $sum_discounted_price= 0;


        foreach  ($itemIds as $item_id) {
            
            $count=$request->item_count[$item_num];

            $menu_item= MenuItem::find($item_id);

            if ($menu_item->available !==1) {
                $bill->delete();
                return $menu_item->name. " " ."غير متوفر حاليا" ;
            }
                        
            auth('sanctum')->check()?$user_id=auth('sanctum')->id():$user_id=null;
            
            $normal_price=$menu_item->price*$count;
            $discounted_price=$menu_item->discounted_price*$count;

            $sum_normal_price+=$normal_price;
            $sum_discounted_price+=$discounted_price;

            $menu_item->offer==0?$price=$normal_price:$price=$discounted_price;

            $order=new Order();
            $request->order_type_id==1 ? $desk=$request->desk_id:$desk=null;
            $order->fill([
                'bill_id'=> $bill->id,
                'customer_id'=>$request->customer_id,
                'user_id'=>$user_id,
                'order_type_id'=>$request->order_type_id,
                'desk_id'=> $desk,
                'order_status_id'=> $request->order_status_id,
                'notes'=> $request->notes,
                'menu_item_id'=>$item_id,
                'price'=> $price,
                'item_count'=>$count,
                'category_id'=>$menu_item->category_id,
                
            ]);
            $order->save();

            $user=User::where("category_id", $order->category_id)
            ->whereTime('workStart','<=',$bill->created_at->format('H:i:s'))
            ->whereTime('workEnd','>=',$bill->created_at->format('H:i:s'))
            ->get();
            foreach( $user as $user_id ) {
                $chef_id=$user_id->id;
                $notification=new Notification();
                $notify=' تم طلب '.$menu_item->name.' عدد '.$count;

                $notification->fill([
                'order_id'=>$order->id,
                'menu_item_id'=>$item_id,
                'user_id'=>$chef_id,
                'notification'=>$notify,
                ]);
            $notification->save();
            }

            $item_num++;

        }

        //calculate prices and discount

        $total_price=Order::where('bill_id',$bill->id)
        ->sum('price');
        
        $discount_percentage=$sum_normal_price-$total_price;

        $cashier=User::where('user_type_id',3)
        ->whereTime('workStart','<=',$bill->created_at->format('H:i:s'))
        ->whereTime('workEnd','>=',$bill->created_at->format('H:i:s'))
        ->first();

        $bill->update([
            'customer_id'=>$request->customer_id,
            'cashier_id'=> $cashier->id??null,
            'total_price'=> $sum_normal_price,
            'discount'=> (float)$discount_percentage,
            'final_price'=>$total_price,
            'order_type_id'=>$order->order_type_id,
        ]);
        $bill->save();

        $orders=Order::with('menu_item.category','order_type')
        ->where('bill_id', $bill->id)
        ->get();
        
        return OrderResource::collection($orders);

    }

    function report(){

        $total_orders=Bill::selectRaw('count(*) as Total,sum(is_paid_id=1) as pending,sum(is_paid_id=2) as done,sum(is_paid_id=3) as canceled')
        ->get();

        $favorite_item=Order::select('menu_item_id','menu_items.name as food')
        ->selectRaw('count(*) as count')
        ->join('menu_items','menu_item_id','=','menu_items.id')
        ->where('order_status_id',4)
        ->groupBy('menu_item_id')
        ->orderBy('count','desc')
        ->limit(5)
        
        ->get();
        return [
            'total_orders'=>$total_orders,
            'top_foods'=>$favorite_item,
        ];


    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    function order_prepaired($id){
        Order::where('id',$id)->update([
            "prepaired_by"=>Auth::id(),
        ]);

    }
    function order_done($id){
        $order=Order::find($id);
        $order->update([
            'done_by'=>Auth::id(),
            'order_status_id'=>4,

        ]);
    }
    public function cancel_order($id)
    {
        //
        $bill=Bill::where('id',$id);
        $bill->update(['is_paid_id'=>3]);
        $orders=Order::where('bill_id',$id)->get();
        
        foreach ($orders as $order){

        
            $order->update([
                'order_status_id'=>3,
            ]);
            $menu_item=MenuItem::where('id',$order->menu_item_id)->first();
            $user=User::where("category_id", $order->category_id)
            // ->whereTime('workStart','<=',$bill->created_at->format('H:i:s'))
            // ->whereTime('workEnd','>=',$bill->created_at->format('H:i:s'))
            ->get();
            foreach( $user as $user_id ) {
                $chef_id=$user_id->id;
                $notification=new Notification();
                $notify=' تم الغاء طلب '.$menu_item->name;

                $notification->fill([
                'order_id'=>$order->id,
                'menu_item_id'=>$order->menu_item_id,
                'user_id'=>$chef_id,
                'notification'=>$notify,
                ]);
            $notification->save();
            }

        }
    }

}