<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class BillController extends Controller
{
    //
    function search(Request $request){
        $orders=Order::where('bill_id',$request->id)->get();

        $items=MenuItem::whereIn('id',$orders->pluck('menu_item_id'))->selectRaw('name as name,price as price')->get();

        $bill =Bill::with('user','customer')
        ->where('bills.id',$request->id)
        ->get();

        $bill=BillResource::collection($bill);
        return ['bill'=>$bill,'bill_items'=> $items];
    }
}
