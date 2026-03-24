<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\ReservaGrupal;
use \App\Models\Espacio;
use \App\Models\Usuario;

class ReservaController extends Controller
{







    /**
     * Listado de reservas para el administrador con buscador y paginación
     */
    public function index(Request $request){
        // cargamos las relaciones
        $query = Reserva::with(['alumno', 'espacio', 'reservaGrupal']);

        // buscador
        if ($request->filled('buscar')) {
            $busqueda = strtolower($request->input('buscar'));
            
            $query->whereHas('alumno', function($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', "%{$busqueda}%");
            })->orWhereHas('espacio', function($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', "%{$busqueda}%");
            })->orWhere('estado', 'LIKE', "%{$busqueda}%");
        }

        // Aplicamos la ordenación
        $campoOrden = $request->input('ordenar_por', 'created_at');
        $direccion = $request->input('direccion', 'desc');

        // Si ordenamos por alumno, hay que hacer un join
        if ($campoOrden === 'alumno') {
            $query->join('usuarios', 'reservas.alumno_id', '=', 'usuarios.id')
                  ->orderBy('usuarios.nombre', $direccion)
                  ->select('reservas.*');
        } else {
            $query->orderBy($campoOrden, $direccion);
        }

        // paginación
        $reservas = $query->paginate(10)->appends($request->query());

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Muestra los detalles de una reserva específica
     */
    public function show(Reserva $reserva){
        // Cargamos la vista de detalle
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Cambia el estado de la reserva a ACEPTADA
     */
    public function aprobar(Reserva $reserva){
        $reserva->estado = 'ACEPTADA';
        $reserva->save();

        return redirect()->back()->with('success', 'La reserva ha sido aprobada correctamente.');
    }

    /**
     * Cambia el estado de la reserva a RECHAZADA
     */
    public function rechazar(Request $request, Reserva $reserva){
        $reserva->estado = 'RECHAZADA';
        
        // Opcional: Si quieres guardar un motivo de rechazo
        if ($request->filled('motivo')) {
            $reserva->motivo_rechazo = $request->input('motivo');
        }
        
        $reserva->save();

        return redirect()->back()->with('success', 'La reserva ha sido rechazada.');
    }

    /**
     * Función para editar una reserva con un formulario
     */
    public function edit(Reserva $reserva){
        // Cargamos los espacios habilitados para el desplegable
        $espacios = \App\Models\Espacio::orderBy('nombre')->get();

        // llamamos a la vista
        return view('reservas.edit', compact('reserva', 'espacios'));
    }

    /**
     * Función para actualizar una reserva desde un formulario con validación
     */
    public function update(Request $request, Reserva $reserva){
        // validamos los campos
        // el espacio tiene que existir y la fecha ser correcta
        $request->validate([
            'estado'      => 'required|string', 
            'espacio_id'  => 'required|exists:espacios,id',
            'hora_inicio' => 'required|date',
            'hora_fin'    => 'required|date|after:hora_inicio',
        ], [
            'hora_fin.after'    => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'espacio_id.exists' => 'El espacio seleccionado no existe en la base de datos.',
            'estado.required'   => 'Debes indicar el estado de la reserva.'
        ]);

        // recuperamos los datos importantes
        $datos = $request->only(['estado', 'espacio_id', 'hora_inicio', 'hora_fin']);

        // actualizamos la DB
        $reserva->update($datos);

        // redirigimos al listado con un mensaje de éxito
        return redirect()->route('reservas.index')->with('success', 'La reserva se ha actualizado correctamente.');
    }

    /**
     * Función que te lleva al formulario para crear una nueva reserva
     */
    public function create(){
        // obtenemos el espacio y el usuario
        $espacios = Espacio::orderBy('nombre')->get();
        $usuarios = Usuario::orderBy('name')->get();

        // redirigimos a la vista con el formulario
        return view('reservas.create', compact('espacios', 'usuarios'));
    }

    /**
     * Guarda una nueva reserva en la base de datos
     */
    public function store(Request $request){
        // validamos los datos
        $request->validate([
            'alumno_id'   => 'required|exists:usuarios,id', 
            'espacio_id'  => 'required|exists:espacios,id',
            'hora_inicio' => 'required|date',
            'hora_fin'    => 'required|date|after:hora_inicio',
            'estado'      => 'required|string',
            'tipo_reserva'=> 'required|in:individual,grupal',
            'aforo_max'   => 'required_if:tipo_reserva,grupal|nullable|integer|min:2',
        ], [
            'hora_fin.after'        => 'La hora de finalización debe ser posterior a la de inicio.',
            'aforo_max.required_if' => 'Debes indicar el aforo máximo para las reservas grupales.',
            'alumno_id.required'    => 'Debes seleccionar un solicitante.',
            'espacio_id.required'   => 'Debes seleccionar un espacio.'
        ]);

        // creamos la reserva principal
        $reserva = Reserva::create([
            'alumno_id'   => $request->alumno_id,
            'espacio_id'  => $request->espacio_id,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin'    => $request->hora_fin,
            'estado'      => $request->estado,
        ]);

        // si la reserva es grupal, creamos su registro asociado
        if ($request->tipo_reserva === 'grupal') {
            ReservaGrupal::create([
                'reserva_id' => $reserva->id,
                'aforo_max'  => $request->aforo_max,
            ]);
        }

        // Redirigimos al listado con un mensaje de éxito
        return redirect()->route('reservas.index')->with('success', 'La reserva se ha creado correctamente.');
    }


    /**
     * Función para borrar una reserva
     */
    public function destroy(Reserva $reserva){
        // si tiene una reserva grupal asociada, la eliminamos primero
        if ($reserva->reservaGrupal) {
            $reserva->reservaGrupal->delete();
        }

        // Eliminamos la reserva principal
        $reserva->delete();

        // Redirigimos al listado con un mensaje de confirmación
        return redirect()->route('reservas.index')->with('success', 'La reserva ha sido eliminada correctamente.');
    }

}