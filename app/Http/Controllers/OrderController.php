<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Bill;
use App\Models\MenuItem;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

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
        //

        
        $orderIds=$request->orderIds;
        // return $orderIds;
        

        $bill=Bill::create([ ]);
        

        


        foreach  ($orderIds as $item_id) {

            $menu_item= MenuItem::find($item_id);
            $order=new Order();
            
            $order->fill([
                'bill_id'=> $bill->id,
                'customer_id'=>$request->customer_id,
                'user_id'=>$request->user_id,
                'order_type_id'=>$request->order_type_id,
                'desk_id'=> $request->desk_id,
                'order_status_id'=> $request->order_status_id,
                'notes'=> $request->notes,
                'menu_item_id'=>$item_id,
                'category_id'=>$menu_item->category_id,
                
            ]);
            $order->save();
        }

        $total_price=Order::with('menu_item.price')
        ->join('menu_items','menu_item_id','=','menu_items.id')
        ->where('bill_id',$bill->id)
        ->sum('price');
        
        

        

        
       // dd($total_price);

        $bill->update([
            'cashier_id'=> $request->cashier_id,
            'total_price'=> $total_price,
        ]);
        $bill->save();

        $orders=Order::with('menu_item.category','order_type')
        ->where('bill_id', $bill->id)
        ->get();

        // $orders=Order::with('menu_item.category','order_type')
        // ->where('bill_id', $bill->id)
        // ->get();
        return OrderResource::collection($orders);

        
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
    public function destroy(Order $order)
    {
        //
    }
}
