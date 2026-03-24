<?php

namespace App\Http\Controllers;
use App\Enums\EstadoEspacio;
use App\Models\Espacio;
use App\Models\Horario;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EspacioController extends Controller
{
    /**
     * Esta es para la pagina del catalogo
     */
    public function catalogo()
    {
        $espacios = Espacio::all();
        return view('reservations', ['espacios' => $espacios]);
    }

    /**
     * Funcion auxiliar que es para la validación del espacio
     */
    private function validarEspacio(Request $request, $id = null)
    {
        //por si el id es null hay que ignorar el unique
        if ($id) {
            $reglaNombre = 'required|string|max:255';
        }
        else {
            $reglaNombre = 'required|string|max:255|unique:espacios,nombre';
        }

        $request->validate([
            'nombre'          => $reglaNombre,
            'aforo'           => 'required|integer|min:1',
            'estado'          => 'required',
            'tipo_espacio_id' => 'required|exists:tipo_espacios,id',
            'localizacion_id' => 'required|exists:localizacions,id',
            'horarios_ids'    => 'required|array|min:1',
            'horarios_ids.*'  => 'exists:horarios,id',
            'imagen'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    /**
     * Función para listar (Read)
     * Encargada de la busqueda, ordenación y paginación
     */
    public function index(Request $request){
        $query = Espacio::with(['tipo', 'localizacion']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('nombre', 'like', '%' . $busqueda . '%')
                ->orWhere('estado', 'like', '%' . $busqueda . '%')
                ->orWhere('aforo', 'like', '%' . $busqueda . '%');
        }

        $campoOrden = $request->input('ordenar_por', 'nombre');
        $direccion = $request->input('direccion', 'asc');
        $query->orderBy($campoOrden, $direccion);

        $espacios = $query->paginate(10)->appends($request->all());

        return view('espacios.index', compact('espacios'));
    }

    /**
     * Función que te lleva al formulario para crear un nuevo espacio
     */
    public function create(){
        $tipos = TipoEspacio::orderBy('nombre')->get();

        //se sacan estas para que no se pueda crear un espacio en una duplicada
        $localizacionesOcupadas = Espacio::pluck('localizacion_id')->toArray();

        //se muestran solo las libres para evitar la duplicacion que se ha dicho antes
        $localizaciones = Localizacion::whereNotIn('id', $localizacionesOcupadas)->get();

        $horarios = Horario::orderBy('inicio')->orderBy('fin')->get();
        $estados = EstadoEspacio::cases();

        return view('espacios.create', compact('tipos', 'localizaciones', 'horarios', 'estados'));
    }

    /**
     * Funcion que va a guardar un nuevo espacio con una validacion previa
     */
    public function store(Request $request){
        $this->validarEspacio($request);
        $datos = $request->only(['nombre', 'aforo', 'estado', 'tipo_espacio_id', 'localizacion_id', 'caracteristicas']);

        // si hay imagen la guardamos en su carpeta publica
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            //se pone el time para que no haya dos fotos con el mismo nombre
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/espacios'), $nombreArchivo);
            $datos['imagen'] = $nombreArchivo;
        }

        $espacio = Espacio::create($datos);
        $espacio->horario()->sync($request->horarios_ids);

        return redirect()->route('espacios.index')->with('success', 'Espacio creado correctamente.');
    }

    /**
     * Función para editar un espacio con un formulario
     */
    public function edit(Espacio $espacio){
        $tipos = TipoEspacio::orderBy('nombre')->get();
        //aqui para la localizacion se pasan todas las libres y la suya para si quiere cambiar
        $localizacionesOcupadas = Espacio::where('id', '!=', $espacio->id)
            ->pluck('localizacion_id')
            ->toArray();

        $localizaciones = Localizacion::whereNotIn('id', $localizacionesOcupadas)->get();
        $horarios = Horario::orderBy('inicio')->orderBy('fin')->get();
        $estados         = EstadoEspacio::cases();
        $horariosActivos = $espacio->horario->pluck('id')->toArray();

        return view('espacios.edit', compact('espacio', 'tipos', 'localizaciones', 'horarios', 'estados', 'horariosActivos'));
    }

    /**
     * Funcion para actualizar un espacio en un formulario con validacion
     */
    public function update(Request $request, Espacio $espacio){
        $this->validarEspacio($request, $espacio->id);
        $datos = $request->only(['nombre', 'aforo', 'estado', 'tipo_espacio_id', 'localizacion_id', 'caracteristicas']);

        if ($request->hasFile('imagen')) {
            //se borra la imagen si habia ya que puede ser null este campo
            if ($espacio->imagen && File::exists(public_path('images/espacios/' . $espacio->imagen))) {
                File::delete(public_path('images/espacios/' . $espacio->imagen));
            }
            //se añade la nueva imagen tras eliminar la otra
            $file = $request->file('imagen');
            //se pone el time para que no haya dos fotos con el mismo nombre
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/espacios'), $nombreArchivo);
            $datos['imagen'] = $nombreArchivo;
        }

        $espacio->update($datos);
        $espacio->horario()->sync($request->horarios_ids);

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente.');
    }

    /**
     * Función para borrar un espacio
     */
    public function destroy(Espacio $espacio){
        //si hay imagen, antes de borrarla de la BD se elimina de la carpeta
        if ($espacio->imagen && File::exists(public_path('images/espacios/' . $espacio->imagen))) {
            File::delete(public_path('images/espacios/' . $espacio->imagen));
        }

        $espacio->delete();
        return redirect()->route('espacios.index')->with('success', 'Espacio eliminado del sistema.');
    }
}
