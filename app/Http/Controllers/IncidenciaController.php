<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Support\Facades\File;

class IncidenciaController extends Controller{
    /**
     * Para la pagina publica del blog
     */
    public function blog(){

        // obtenemos todas las incidencias
        // como necesitamos el usuario, lo obtenemos con with
        $incidencias = Incidencia::with(['usuario'])->get();

        // lo enviamos a la vista del blog de incidencias
        return view('blog', compact('incidencias'));
    }

    /**
     * Función auxiliar para la validación de la incidencia
     */
    private function validarIncidencia(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'user_id'     => 'required|exists:usuarios,id',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    /**
     * Funcion para listar
     */
    public function index(Request $request){
        $query = Incidencia::with(['usuario']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('descripcion', 'like', '%' . $busqueda . '%')
                ->orWhereHas('usuario', function($q) use ($busqueda) {
                    $q->where('name', 'like', '%' . $busqueda . '%')
                        ->orWhere('email', 'like', '%' . $busqueda . '%');
                });
        }

        $campoOrden = $request->input('ordenar_por', 'id');
        $direccion = $request->input('direccion', 'desc');

        if ($campoOrden === 'usuario') {
            $query->join('usuarios', 'incidencias.user_id', '=', 'usuarios.id')
                ->orderBy('usuarios.name', $direccion)
                ->select('incidencias.*');
        }
        else {
            $query->orderBy($campoOrden, $direccion);
        }

        $incidencias = $query->paginate(10)->appends($request->all());

        return view('incidencias.index', compact('incidencias'));
    }

    /***
     * Funcion para crear una incidencia
     */
    public function create()
    {
        $usuarios = Usuario::orderBy('name')->get();
        return view('incidencias.create', compact('usuarios'));
    }

    /**
     * Funcion para guardar
     */
    public function store(Request $request)
    {
        $this->validarIncidencia($request);

        $datos = $request->only(['descripcion', 'user_id']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/incidencias'), $nombreArchivo);
            $datos['foto'] = $nombreArchivo;
        }

        Incidencia::create($datos);
        return redirect()->route('incidencias.index')->with('success', 'Incidencia reportada correctamente.');
    }

    /**
     * Funcion para editar
     */
    public function edit(Incidencia $incidencia)
    {
        $usuarios = Usuario::orderBy('name')->get();
        return view('incidencias.edit', compact('incidencia', 'usuarios'));
    }

    /**
     * Funcion para actualizar
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        $this->validarIncidencia($request);

        $datos = $request->only(['descripcion', 'user_id']);

        if ($request->hasFile('foto')) {
            if ($incidencia->foto && File::exists(public_path('images/incidencias/' . $incidencia->foto))) {
                File::delete(public_path('images/incidencias/' . $incidencia->foto));
            }

            $file = $request->file('foto');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/incidencias'), $nombreArchivo);
            $datos['foto'] = $nombreArchivo;
        }

        $incidencia->update($datos);
        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada correctamente.');
    }

    /**
     * Funcion para borrar
     */
    public function destroy(Incidencia $incidencia)
    {
        if ($incidencia->foto && File::exists(public_path('images/incidencias/' . $incidencia->foto))) {
            File::delete(public_path('images/incidencias/' . $incidencia->foto));
        }

        $incidencia->delete();
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada del sistema.');
    }
}
