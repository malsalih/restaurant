<?php

namespace App\Http\Controllers;

use App\Events\OrderCanceled;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Bill;
use App\Models\MenuItem;
use App\Models\Notification;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\User;
use App\Listeners;
use App\Events\OrderReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $menuItems = Order::with('menu_item.category','order_type')->get();
        return (OrderResource::collection($menuItems));

    }

    public function index_by_user(Request $request)
    {
        $filters=[];
        $request->filled('order_status_id') ? $filters []= ['order_status_id', '=', $request->order_status_id]: 0;
        $request->filled('order_type_id') ? $filters []= ['order_type_id', '=', $request->order_type_id]: 0;



        $menuItems = Order::with('menu_item.category','order_type')
        ->where('category_id',Auth::user()->category_id)
        ->where($filters)
        ->get();
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
            
            $count=$request->item_count[$item_num]??$count=1;

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
            event(new OrderReceived($order->fill([
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
                
            ])));
            $order->save();

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
        

        $prep_time=MenuItem::where('id',$order->menu_item_id)
        ->max('prep_time');

        $bill->update([
            'customer_id'=>$request->customer_id,
            'user_id'=> $cashier->id??null,
            'total_price'=> $sum_normal_price,
            'discount'=> (float)$discount_percentage,
            'final_price'=>$total_price,
            'preparation_time'=>$prep_time,
            'order_type_id'=>$order->order_type_id,
        ]);
        $bill->save();

        $orders=Order::with('menu_item.category','order_type')
        ->where('bill_id', $bill->id)
        ->get();
        
        return OrderResource::collection($orders);

    }

    function report(){

        $total_bills=Bill::selectRaw('count(*) as Total,sum(is_paid_id=1) as pending,sum(is_paid_id=2) as done,sum(is_paid_id=3) as canceled')
        ->get();

        $total_orders=Order::selectRaw('count(*) as Total,sum(order_status_id=1) as pending,sum(order_status_id=2) as in_delivery,sum(order_status_id=3) as canceled,sum(order_status_id=4) as Done')
        ->get();
        $top_customers=Order::select('customer_id','customers.name as name')
        ->selectRaw('count(*) as count')
        ->join('customers','customer_id','=','customers.id')
        ->where("order_status_id",4)
        ->groupBy('customer_id')
        ->orderBy('count','desc')
        ->limit(5)
        ->get();

        $top_chefs=Order::select('done_by','users.name as name')
        ->selectRaw('count(*) as count')
        ->join('users','done_by','=','users.id')
        ->where("order_status_id",4)
        ->groupBy('done_by')
        ->orderBy('count','desc')
        ->limit(5)
        ->get();

        $favorite_item=Order::select('menu_item_id','menu_items.name as food')
        ->selectRaw('count(*) as count')
        ->join('menu_items','menu_item_id','=','menu_items.id')
        ->where('order_status_id',4)
        ->groupBy('menu_item_id')
        ->orderBy('count','desc')
        ->limit(10)    
        ->get();

        return [
            'total_bills'=>$total_bills,
            'total_orders'=>$total_orders,
            'top_chefs'=>$top_chefs,
            'top_customers'=>$top_customers,
            'top_foods'=>$favorite_item,
        ];


    }

    function order_prepaired($id){
        $order=Order::where('id',$id);
        $order->update([
            "prepaired_by"=>Auth::id(),
        ]);

    }
    function order_done($id){
        $order=Order::find($id);
        if($order->order_status_id==4){
            return 'already done';
        }else if($order->order_status_id== 3){
            return 'its a canceled order';
        }
        $order->update([
            'done_by'=>Auth::id(),
            'order_status_id'=>4,

        ]);
        return 'order is done';
    }

    function in_delivery($id){
        
        $orders=Order::where('bill_id',$id)->get();
        foreach($orders as $order){

        if($order->order_type_id==1){
            return "this is not delivery type order";
        }
        $order->update([
            'done_by'=>Auth::id(),
            'order_status_id'=>2,

        ]);
        return "your order is on its way";
    }
    }
    public function cancel_order($id)
    {
        //
        $bill=Bill::where('id',$id);
        $bill->update(['is_paid_id'=>3]);
        $orders=Order::where('bill_id',$id)->get();
        
        foreach ($orders as $order){


            event(new OrderCanceled($order));
            $order->update([
                'order_status_id'=>3,
            ]);
            $menu_item=MenuItem::where('id',$order->menu_item_id)->first();
            $user=User::where("category_id", $order->category_id)
            // ->whereTime('workStart','<=',$bill->created_at->format('H:i:s'))
            // ->whereTime('workEnd','>=',$bill->created_at->format('H:i:s'))
            ->get();
            
            

        }
    }

}