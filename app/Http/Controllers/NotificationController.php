<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller{

    // Debería usar middleware(auth) y usar el usuario autenticado, pero aún no está disponible
    public function getNotificationsAsUser(){
        if (!Auth::check()) {
            abort(403, 'Usuario no autenticado en perfil');
        }
        $user = Usuario::first();
        $notifications = Notificacion::where('user_id', $user->id)->where('vista', false)->get();
        return view('main', ['notifications' => $notifications]);
    }

    public function viewNotification(string $id) {
        
        $notification = Notificacion::findOrFail($id);
        $notification->update(['vista' => true]);        
        $notification->save();
        return back();
    }

    // Debería usar middleware(auth) y usar el usuario autenticado, pero aún no está disponible
    public function viewAllNotificationsAsUser(){
        $user = Usuario::first();
        $notifications = Notificacion::where('user_id', $user->id)->update(['vista' => true]);
        return back();
    }
}