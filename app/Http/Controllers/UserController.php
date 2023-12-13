<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
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
        // //dd(UserTypeResource::collection($users));
        return UserResource::collection($users);
        // $menuItem=MenuItem::all();
        // return MenuItemResource::collection($menuItem);
    }

    public function create(StoreUserRequest $request){
        $user = User::create($request->except('category_id'));

        // if(Auth()->user()->can('create', User::class)){

        $request->user_type_id == 4|| $request->user_type_id==5 ? Chef::create([
            'chef' => $user->name,
            'category_id'=> $request->category_id,

            ]):0;  


        return $user;
        // }
    //    return 'unauthinticated';
       // dd(Auth::user()->email);


        
    }

    function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        $check_active=$user->isActive==true?1:0;

        if (!$user || !Hash::check($request->password, $user->password  )) {
           
            return (
              'The provided credentials are incorrect.'
            
            );
        }
        
        elseif($check_active== 0){
            return(
                'User is inactive'
            );
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
        $user = User::find( $id);
        $user->update(
            ["isActive"=>false]
        );
    }

        

}
