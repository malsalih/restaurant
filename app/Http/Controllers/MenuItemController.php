<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ChefResource;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Chef;
use App\Models\MenuItem;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $menuItems = MenuItem::with("order.menu_item.category")
        // ->where('available',true)
        // ->get()
        
        // ->groupBy('menu_items.category_id');
        // ->toArray();

        // return (MenuItemResource::collection($menuItems));
        // return (MenuItemResource::collection($menuItems));
        // return (ChefResource::collection($menuItems));
        // return (CategoryResource::collection($menuItems));
        

        $items=MenuItem::selectRaw('categories.category ,menu_items.name as Item, menu_items.price as price,menu_items.image as Image')
        // ->with("menu_item.category")
        // $items = MenuItem::all()
        ->where("available",true)
        ->join('categories','category_id','=','categories.id')
        ->get()
        ->groupBy("category");

        return ([$items]);

        // $items = MenuItem::all()->groupBy('categories.category');
        // return MenuItemResource::collection($items);


    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request)
    {
        //

        $menuItem = new MenuItem();
        $menuItem->fill($request->except('image'));

        if($request->hasFile("image")){

            $file = $request->file("image");
            $extension= $file->getClientOriginalExtension();
            $fileName= time().".".$extension;
            $file->move("uploads/items/", $fileName);
            $menuItem->image = $fileName;
        }

        $menuItem->save();

        return $menuItem;


       

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, int $id)
    {
        //
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($request->except('image'));
        $imagePath=$menuItem->image;

        if ($request->hasFile('image' ) ) {
            
            $menuItem->image !=null ? unlink(public_path('uploads/items/'). basename($imagePath)):0;


            $file = $request->file("image");
            $extension= $file->getClientOriginalExtension();
            $fileName= time().".".$extension;
            $file->move("uploads/items/", $fileName);
            $menuItem->image = $fileName;
        }

        $menuItem->save();

        return $menuItem;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $menuItem=MenuItem::findOrFail($id);
        $imagePath=$menuItem->image;

        $menuItem->image !=null ? unlink(public_path('uploads/items/'). basename($imagePath)):0;

        $menuItem->delete();

        return "Item deleted successfully";

    }
}
