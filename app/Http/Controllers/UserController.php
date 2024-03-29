<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTypeResource;
use App\Models\Chef;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return UserResource::collection($users);

    }

    public function create(StoreUserRequest $request){
        if(Auth()->user()->can('create', User::class)){

        $user = User::create($request->except('category_id'));


        $request->user_type_id == 4 ? $user->update([
            
            'category_id'=> $request->category_id,

            ]):0;  


        return $user;
        }
       return 'unauthinticated';
        
    }

    function update(UpdateUserRequest $request,$id){
        if(Auth()->user()->can('update', User::class)){

        $user = User::findOrFail($id);
        $user->update($request->only('category_id','name','email','password','phone','address','user_type_id','category_id','isActive','workStart','workEnd','salary',));
        }
    }

    function login(LoginRequest $request){
        $user = User::where('email', $request->email)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password  )) {
           return "The provided credentials are incorrect.";
        }
        
        elseif($user->isActive == 0){
            return "User is inactive";

        }

        ($user->workStart<=now()->format('H:i:s') && $user->workEnd>=now()->format('H:i:s') || $user->user_type_id==1 )== true 
        ? $error=0:$error=1;

        if ($error==1) {
            return "Outside work hours";
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return ([
            'Id' => $user->id,
            'Name' => $user->name,
            'AccessToken' => $token
        ]);
    }

    function active(int $id){
        $user = User::find( $id);
        $user->update(
            ["isActive"=>true]
        );
    }

    function delete(int $id){
        if(Auth()->user()->can('delete', User::class)){
        $user = User::find( $id);
        $user->update(
            ["isActive"=>false]
        );
    }
    }

        

}
