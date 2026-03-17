<?php

namespace App\Http\Controllers;
use App\Models\TipoEspacio;
use Illuminate\Http\Request;

class TipoEspacioController extends Controller
{
    /**
     * Función para listar (Read)
     * Encargada de la busqueda, ordenación y paginación
     */
    public function index(Request $request){
        $query = TipoEspacio::query();

        //para la busqueda por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->input('buscar') . '%');
        }

        //ordenación, por defecto la vamos a hacer ascendente por el nombre ya que solo se trata de este campo
        $campoOrden = $request->input('ordenar_por', 'nombre');
        $direccion = $request->input('direccion', 'asc');
        $query->orderBy($campoOrden, $direccion);

        //paginación, vamos a mostrar 10 elementos por pagina y con el append no se pierde la busqueda y ordenacion al pasar de pagina
        $tipos = $query->paginate(10)->appends($request->all());

        return view('tipos_espacio.index', compact('tipos'));
    }

    /**
     * Función que te lleva al formulario para crear un nuevo tipo de espacio
     */
    public function create(){
        return view('tipos_espacio.create');
    }

    /**
     * Funcion que va a guardar un nuevo tipo de espacio con una validacion previa
     * Esta validación es que el nombre debe ser obligatorio y unico al ser la clave primaria de nuestra tabla
     * En /lang/es/validation.php se ha personalizado los mensajes como se ha visto en la teoria
     */
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_espacios,nombre'
        ]);
        TipoEspacio::create($request->all());
        return redirect()->route('tipos-espacio.index')->with('success', 'Tipo de espacio creado con éxito.');
    }

    /**
     * Función para editar un tipo de espacio con un formulario
     */
    public function edit(TipoEspacio $tipos_espacio){
        return view('tipos_espacio.edit', ['tipo' => $tipos_espacio]);
    }

    /**
     * Funcion para actualizar un tipo de espacio en un formulario con validacion
     * La validacion es igual que en el store
     */
    public function update(Request $request, TipoEspacio $tipos_espacio){
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_espacios,nombre,' . $tipos_espacio->id
        ]);
        $tipos_espacio->update($request->all());
        return redirect()->route('tipos-espacio.index')->with('success', 'Tipo de espacio actualizado correctamente.');
    }

    /**
     * Función para borrar un tipo de espacio
     */
    public function destroy(TipoEspacio $tipos_espacio){
        $tipos_espacio->delete();
        return redirect()->route('tipos-espacio.index')->with('success', 'Tipo de espacio eliminado.');
    }

}
