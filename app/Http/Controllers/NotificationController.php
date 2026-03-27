<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller{

    public function getNotificationsAsUser(){

        $user = Auth::user();
        $notifications = Notificacion::where('user_id', $user->id)->where('vista', false)->get();
        return view('main', ['notifications' => $notifications]);
    }

    public function viewNotification(string $id) {

        $notification = Notificacion::findOrFail($id);
        $notification->update(['vista' => true]);        
        $notification->save();
        return back();
    }

    public function viewAllNotificationsAsUser(){

        Notificacion::where('user_id', Auth::user()->id)->update(['vista' => true]);
        return back();
    }
}