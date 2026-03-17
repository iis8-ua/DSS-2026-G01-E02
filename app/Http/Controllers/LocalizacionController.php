<?php

namespace App\Http\Controllers;
use App\Models\Localizacion;
use Illuminate\Http\Request;

class LocalizacionController extends Controller
{
    /**
     * Funcion que ayuda a que se busque por las tres claves, que forman la primaria
     */
    private function buscarPorClaves($id_compuesto){
        $claves = explode('_', $id_compuesto);
        if (count($claves) !== 3) {
            abort(404);
        }
        return Localizacion::where('latitud', $claves[0])
            ->where('longitud', $claves[1])
            ->where('piso', $claves[2])
            ->firstOrFail();
    }

    /**
     * Función para listar (Read)
     * Encargada de la busqueda, ordenación y paginación
     */
    public function index(Request $request){
        $query = Localizacion::query();

        //para la busqueda del edificio, se va a buscar en todos los campos que contengan lo que el usuario quiere ya que lo vemos lo mas acertado
        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');

            $query->where('piso', 'like', '%' . $busqueda . '%')
                ->orWhere('latitud', 'like', '%' . $busqueda . '%')
                ->orWhere('longitud', 'like', '%' . $busqueda . '%');
        }

        //ordenación por defecto es por el piso, si el usuario no toca nada luego en la vista se ordena por el piso, se podria cambiar pero es una manera de ordenar
        $campoOrden = $request->input('ordenar_por', 'piso');
        $direccion = $request->input('direccion', 'asc');
        $query->orderBy($campoOrden, $direccion);

        //paginación, al igual que en el tipo espacio vamos a paginar con 10 y con el append
        $localizaciones = $query->paginate(10)->appends($request->all());

        return view('localizaciones.index', compact('localizaciones'));
    }

    /**
     * Función que te lleva al formulario para crear una nueva localización
     */
    public function create(){
        return view('localizaciones.create');
    }

    /**
     * Funcion que va a guardar una nueva localizacion con una validacion previa
     */
    public function store(Request $request){
        $request->validate([
            'latitud'  => 'required|numeric',
            'longitud' => 'required|numeric',
            'piso'     => 'required|integer',
        ]);

        //con esto se evita que haya un duplicado igual
        $existe = Localizacion::where('latitud', $request->latitud)
            ->where('longitud', $request->longitud)
            ->where('piso', $request->piso)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya existe una localización exacta con esas coordenadas y piso.')->withInput();
        }

        Localizacion::create($request->all());
        return redirect()->route('localizaciones.index')->with('success', 'Localización creada con éxito.');
    }

    /**
     *  Función para editar una localización con un formulario
     */
    public function edit($id)
    {
        $localizacion = $this->buscarPorClaves($id);
        return view('localizaciones.edit', compact('localizacion', 'id'));
    }

    /**
     * Funcion para actualizar una localización en un formulario con validacion
     * La validacion es igual que en el store
     */
    public function update(Request $request, $id){
        $request->validate([
            'latitud'  => 'required|numeric',
            'longitud' => 'required|numeric',
            'piso'     => 'required|integer',
        ]);

        $localizacion = $this->buscarPorClaves($id);

        Localizacion::where('latitud', $localizacion->latitud)
            ->where('longitud', $localizacion->longitud)
            ->where('piso', $localizacion->piso)
            ->update($request->except(['_token', '_method']));

        return redirect()->route('localizaciones.index')->with('success', 'Localización actualizada correctamente.');
    }

    /**
     * Función para borrar una localización
     */
    public function destroy($id){
        $localizacion = $this->buscarPorClaves($id);

        Localizacion::where('latitud', $localizacion->latitud)
            ->where('longitud', $localizacion->longitud)
            ->where('piso', $localizacion->piso)
            ->delete();

        return redirect()->route('localizaciones.index')->with('success', 'Localización eliminada del sistema.');
    }
}
