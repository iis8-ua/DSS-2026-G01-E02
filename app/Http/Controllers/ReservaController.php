<?php

namespace App\Http\Controllers;

use App\Enums\EstadoReserva;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Espacio;
use App\Models\Usuario;

class ReservaController extends Controller
{
    /**
     * Listado de reservas para el administrador con buscador y paginación
     */
    public function index(Request $request){
        $query = Reserva::with(['alumno', 'espacio']);

        if ($request->filled('buscar')) {
            $busqueda = strtolower($request->input('buscar'));

            $query->where(function($qPrincipal) use ($busqueda) {
                $qPrincipal->whereHas('alumno', function($q) use ($busqueda) {
                    $q->where('name', 'LIKE', "%{$busqueda}%");
                })->orWhereHas('espacio', function($q) use ($busqueda) {
                    $q->where('nombre', 'LIKE', "%{$busqueda}%");
                })->orWhere('estado', 'LIKE', "%{$busqueda}%");
            });
        }

        $campoOrden = $request->input('ordenar_por', 'id');
        $direccion = $request->input('direccion', 'desc');

        if ($campoOrden === 'alumno') {
            $query->join('usuarios', 'reservas.alumno_id', '=', 'usuarios.id')
                  ->orderBy('usuarios.name', $direccion)
                  ->select('reservas.*');
        } else {
            $query->orderBy("reservas.{$campoOrden}", $direccion);
        }

        $reservas = $query->paginate(10)->appends($request->query());

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Mostrar reservas del usuario autenticado
     */
    public function misReservas()
    {
        $reservas = Reserva::with('espacio')
            ->where('alumno_id', auth()->id())
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('reservas.mias', compact('reservas'));
    }

    /**
     * Muestra los detalles de una reserva específica
     */
    public function show(Reserva $reserva){
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Cambia el estado de la reserva a ACEPTADA
     */
    public function aprobar(Reserva $reserva){
        $reserva->estado = EstadoReserva::ACEPTADA;
        $reserva->save();

        return redirect()->back()->with('success', 'La reserva ha sido aprobada correctamente.');
    }

    /**
     * Cambia el estado de la reserva a RECHAZADA
     */
    public function rechazar(Request $request, Reserva $reserva){
        $reserva->estado = EstadoReserva::RECHAZADA;
        $reserva->save();

        return redirect()->back()->with('success', 'La reserva ha sido rechazada.');
    }

    /**
     * Formulario de nueva reserva desde el catálogo
     */
    public function nueva(Espacio $espacio)
    {
        $horariosDisponibles = $espacio->horario()->orderBy('inicio')->get();

        $reservasExistentes = Reserva::where('espacio_id', $espacio->id)
            ->orderBy('hora_inicio')
            ->get();

        return view('new_reservation', compact('espacio', 'horariosDisponibles', 'reservasExistentes'));
    }

    /**
     * Guardar nueva reserva desde el catálogo
     */
    public function guardarNueva(Request $request, Espacio $espacio)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horaInicioTexto = $request->hora_inicio;
        $horaFinTexto = $request->hora_fin;

        $horarioValido = $espacio->horario()->get()->contains(function ($horario) use ($horaInicioTexto, $horaFinTexto) {
            $inicioHorario = $horario->inicio->format('H:i');
            $finHorario = $horario->fin->format('H:i');

            return $horaInicioTexto >= $inicioHorario && $horaFinTexto <= $finHorario;
        });

        if (!$horarioValido) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora_inicio' => 'La franja seleccionada no está dentro del horario disponible del espacio.'
                ]);
        }

        $inicio = $request->fecha . ' ' . $horaInicioTexto . ':00';
        $fin = $request->fecha . ' ' . $horaFinTexto . ':00';

        $solapa = Reserva::where('espacio_id', $espacio->id)
            ->where(function ($query) use ($inicio, $fin) {
                $query->where('hora_inicio', '<', $fin)
                      ->where('hora_fin', '>', $inicio);
            })
            ->exists();

        if ($solapa) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora_inicio' => 'Ya existe una reserva en ese tramo horario.'
                ]);
        }

        Reserva::create([
            'alumno_id' => auth()->id(),
            'espacio_id' => $espacio->id,
            'hora_inicio' => $inicio,
            'hora_fin' => $fin,
            'estado' => EstadoReserva::PENDIENTE,
        ]);

        return redirect()->route('reservas.mias')
            ->with('success', 'La reserva se ha creado correctamente.');
    }

    /**
     * Función para editar una reserva con un formulario
     */
    public function edit(Reserva $reserva){
        $espacios = Espacio::orderBy('nombre')->get();
        return view('reservas.edit', compact('reserva', 'espacios'));
    }

    /**
     * Función para actualizar una reserva desde un formulario con validación
     */
    public function update(Request $request, Reserva $reserva){
        $request->validate([
            'estado'      => 'required|string',
            'espacio_id'  => 'required|exists:espacios,id',
            'hora_inicio' => 'required|date',
            'hora_fin'    => 'required|date|after:hora_inicio',
        ]);

        $datos = $request->only(['estado', 'espacio_id', 'hora_inicio', 'hora_fin']);
        $reserva->update($datos);

        return redirect()->route('reservas.index')->with('success', 'La reserva se ha actualizado correctamente.');
    }

    /**
     * Función que te lleva al formulario para crear una nueva reserva
     */
    public function create(){
        $espacios = Espacio::orderBy('nombre')->get();
        $usuarios = Usuario::orderBy('name')->get();

        return view('reservas.create', compact('espacios', 'usuarios'));
    }

    /**
     * Guarda una nueva reserva en la base de datos
     */
    public function store(Request $request){
        $request->validate([
            'alumno_id'   => 'required|exists:usuarios,id',
            'espacio_id'  => 'required|exists:espacios,id',
            'hora_inicio' => 'required|date',
            'hora_fin'    => 'required|date|after:hora_inicio',
            'estado'      => 'required|string',
        ]);

        Reserva::create([
            'alumno_id'   => $request->alumno_id,
            'espacio_id'  => $request->espacio_id,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin'    => $request->hora_fin,
            'estado'      => $request->estado,
        ]);

        return redirect()->route('reservas.index')->with('success', 'La reserva se ha creado correctamente.');
    }

    /**
     * Función para borrar una reserva
     */
    public function destroy(Reserva $reserva){
        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'La reserva ha sido eliminada correctamente.');
    }
}