<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
         return $user->unreadNotifications;
        
        
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function mark_Notification($id)
    {
        //
        $user=Auth::user();
        $user->unreadNotifications
        ->where('id',$id)->markAsRead();
    }

    
}
