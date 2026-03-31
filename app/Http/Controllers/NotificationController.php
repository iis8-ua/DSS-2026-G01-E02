<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Usuario;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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

    /**
     * Funcion para validar una notificacion
     */
    private function validarNotificacion(Request $request){
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'texto'        => 'required|string|max:1000',
            'user_id'      => 'required|exists:usuarios,id',
            'incidencia_id'=> 'nullable|exists:incidencias,id',
            'vista'        => 'boolean',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    /**
     * Funcion para listar las notificaciones
     */
    public function index(Request $request){
        $query = Notificacion::with(['usuario', 'incidencia']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('titulo', 'like', '%' . $busqueda . '%')
                ->orWhere('texto', 'like', '%' . $busqueda . '%')
                ->orWhereHas('usuario', function ($q) use ($busqueda) {
                    $q->where('name', 'like', '%' . $busqueda . '%')
                        ->orWhere('email', 'like', '%' . $busqueda . '%');
                });
        }

        $campoOrden = $request->input('ordenar_por', 'id');
        $direccion  = $request->input('direccion', 'desc');

        if ($campoOrden === 'usuario') {
            $query->join('usuarios', 'notificaciones.user_id', '=', 'usuarios.id')
                ->orderBy('usuarios.name', $direccion)
                ->select('notificaciones.*');
        }
        else {
            $query->orderBy($campoOrden, $direccion);
        }

        $notificaciones = $query->paginate(10)->appends($request->all());

        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Funcion para crear una notificacion
     */
    public function create(){
        $usuarios    = Usuario::orderBy('name')->get();
        $incidencias = Incidencia::orderBy('id', 'desc')->get();
        return view('notificaciones.create', compact('usuarios', 'incidencias'));
    }

    /**
     * FUncion para guardar una notificacion
     */
    public function store(Request $request){
        $this->validarNotificacion($request);

        $datos = $request->only(['titulo', 'texto', 'user_id', 'incidencia_id']);
        $datos['vista'] = $request->boolean('vista', false);

        if ($request->hasFile('imagen')) {
            $file= $request->file('imagen');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/notificaciones'), $nombreArchivo);
            $datos['imagen'] = $nombreArchivo;
        }

        Notificacion::create($datos);
        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    /**
     * Funcion para editar la notificacion
     */
    public function edit(Notificacion $notificacion)
    {
        $usuarios    = Usuario::orderBy('name')->get();
        $incidencias = Incidencia::orderBy('id', 'desc')->get();
        return view('notificaciones.edit', compact('notificacion', 'usuarios', 'incidencias'));
    }

    public function update(Request $request, Notificacion $notificacion)
    {
        $this->validarNotificacion($request);

        $datos = $request->only(['titulo', 'texto', 'user_id', 'incidencia_id']);
        $datos['vista'] = $request->boolean('vista', false);

        if ($request->hasFile('imagen')) {
            if ($notificacion->imagen && File::exists(public_path('images/notificaciones/' . $notificacion->imagen))) {
                File::delete(public_path('images/notificaciones/' . $notificacion->imagen));
            }

            $file= $request->file('imagen');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/notificaciones'), $nombreArchivo);
            $datos['imagen'] = $nombreArchivo;
        }

        $notificacion->update($datos);
        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    /**
     * Funcion para borrar una notificacion
     */
    public function destroy(Notificacion $notificacion){
        if ($notificacion->imagen && File::exists(public_path('images/notificaciones/' . $notificacion->imagen))) {
            File::delete(public_path('images/notificaciones/' . $notificacion->imagen));
        }

        $notificacion->delete();
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada del sistema.');
    }
}
