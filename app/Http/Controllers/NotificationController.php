<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller{

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