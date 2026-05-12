<?php

namespace App\Http\Controllers;

use App\Enums\EstadoReserva;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\ReservaGrupal;
use App\Services\ReservaGrupalService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReservaGrupalController extends Controller
{
    /**
     * Funcion para validar una reserva grupal
     */
    private function validarReservaGrupal(Request $request){
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'aforo_max'  => 'required|integer|min:1',
        ]);

        $totalAlumnos = count($request->alumnos ?? []);
        if ($totalAlumnos > $request->aforo_max) {
            throw ValidationException::withMessages([
                'alumnos' => __('validation.custom.alumnos.max'),
            ]);
        }
    }

    /**
     * Función para listar
     */
    public function index(Request $request){
        $query = ReservaGrupal::with(['reserva.espacio', 'reserva.alumno', 'alumnos']);

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('reserva_id', 'like', '%' . $busqueda . '%')
                ->orWhereHas('reserva.espacio', function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', '%' . $busqueda . '%');
                })
                ->orWhereHas('alumnos', function ($q) use ($busqueda) {
                    $q->where('name', 'like', '%' . $busqueda . '%')
                        ->orWhere('email', 'like', '%' . $busqueda . '%');
                });
        }

        $campoOrden = $request->input('ordenar_por', 'reserva_id');
        $direccion  = $request->input('direccion', 'desc');
        $query->orderBy($campoOrden, $direccion);

        $reservasGrupales = $query->paginate(10)->appends($request->all());

        return view('reservas-grupales.index', compact('reservasGrupales'));
    }

    /**
     * Función para crear
     */
    public function create()
    {
        //se filtran las ya creadas para que no pueda haber duplicados
        $reservasOcupadas = ReservaGrupal::pluck('reserva_id');
        $reservas = Reserva::with(['espacio', 'alumno'])
            ->whereNotIn('id', $reservasOcupadas)
            ->orderBy('hora_inicio', 'desc')
            ->get();

        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->orderBy('name')->get();

        return view('reservas-grupales.create', compact('reservas', 'alumnos'));
    }

    /**
     * Función para guardar
     */
    public function store(Request $request)
    {
        $this->validarReservaGrupal($request);

        ReservaGrupalService::crear([
            'reserva_id' => $request->reserva_id,
            'aforo_max'  => $request->aforo_max,
        ], $request->alumnos ?? []);

        return redirect()->route('reservas-grupales.index')->with('success', 'Reserva grupal creada correctamente.');
    }

    /**
     * Función para ver
     */
    public function show(ReservaGrupal $reservasGrupal)
    {
        $reservasGrupal->load(['reserva.espacio', 'reserva.alumno', 'alumnos']);
        return view('reservas-grupales.show', compact('reservasGrupal'));
    }

    /**
     * Función para editar
     */
    public function edit(ReservaGrupal $reservasGrupal)
    {
        $reservas = Reserva::with(['espacio', 'alumno'])
            ->orderBy('hora_inicio', 'desc')
            ->get();

        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->orderBy('name')->get();
        $alumnosSeleccionados = $reservasGrupal->alumnos->pluck('id')->toArray();

        return view('reservas-grupales.edit', compact('reservasGrupal', 'reservas', 'alumnos', 'alumnosSeleccionados'));
    }

    /**
     * Función para actualizar
     */
    public function update(Request $request, ReservaGrupal $reservasGrupal)
    {
        $this->validarReservaGrupal($request);

        $reservasGrupal->update([
            'aforo_max' => $request->aforo_max,
        ]);

        $reservasGrupal->alumnos()->sync($request->alumnos ?? []);

        return redirect()->route('reservas-grupales.index')->with('success', 'Reserva grupal actualizada correctamente.');
    }

    /**
     * Función para borrar
     */
    public function destroy(ReservaGrupal $reservasGrupal)
    {
        ReservaGrupalService::eliminar($reservasGrupal);
        return redirect()->route('reservas-grupales.index')->with('success', 'Reserva grupal eliminada del sistema.');
    }

    public function nuevaGrupal(Espacio $espacio, Request $request)
    {
        $horariosDisponibles = $espacio->horario()->orderBy('inicio')->get();
        $fecha = $request->input('fecha');
        $reservasExistentes = collect();
        $horariosOcupados = collect();

        if ($fecha) {
            $reservasExistentes = Reserva::where('espacio_id', $espacio->id)
                ->whereDate('hora_inicio', $fecha)
                ->whereNotIn('estado', [EstadoReserva::CANCELADA, EstadoReserva::RECHAZADA])
                ->get();

            $horariosOcupados = $reservasExistentes->where('estado', EstadoReserva::ACEPTADA);
        }

        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->orderBy('name')->get();

        return view('new_reservation_grupal', compact('espacio', 'horariosDisponibles', 'reservasExistentes', 'horariosOcupados', 'fecha', 'alumnos'));
    }

    public function guardarNuevaGrupal(Request $request, Espacio $espacio)
    {
        $request->validate([
            'fecha'     => 'required|date|after_or_equal:today',
            'horario'   => 'required',
            'aforo_max' => 'required|integer|min:2|max:' . $espacio->aforo,
        ]);

        $request->validate([
            'alumnos'   => 'required|array|min:2|max:' . $request->aforo_max,
            'alumnos.*' => 'exists:usuarios,id',
        ]);

        $horario = explode(' - ', $request->horario);
        $inicio  = $request->fecha . ' ' . $horario[0] . ':00';
        $fin     = $request->fecha . ' ' . $horario[1] . ':00';

        if (\Carbon\Carbon::parse($inicio)->isPast()) {
            return back()->withInput()->withErrors([
                'horario' => 'No puedes reservar en un horario que ya ha pasado.'
            ]);
        }

        $solapa = Reserva::where('espacio_id', $espacio->id)
            ->whereNotIn('estado', [EstadoReserva::CANCELADA, EstadoReserva::RECHAZADA])
            ->where(function ($query) use ($inicio, $fin) {
                $query->where('hora_inicio', '<', $fin)
                    ->where('hora_fin', '>', $inicio);
            })
            ->exists();

        if ($solapa) {
            return back()->withInput()->withErrors([
                'hora_inicio' => 'Ya existe una reserva en ese tramo horario.'
            ]);
        }

        $reserva = Reserva::create([
            'alumno_id'   => auth()->id(),
            'espacio_id'  => $espacio->id,
            'hora_inicio' => $inicio,
            'hora_fin'    => $fin,
            'estado'      => EstadoReserva::PENDIENTE,
        ]);

        $reservaGrupal = ReservaGrupal::create([
            'reserva_id' => $reserva->id,
            'aforo_max'  => $request->aforo_max,
        ]);

        $reservaGrupal->alumnos()->sync($request->alumnos);

        return redirect()->route('reservas.mias')
            ->with('success', 'La reserva grupal se ha creado correctamente.');
    }

    public function editarMiembros(ReservaGrupal $reservasGrupal)
    {
        $reservasGrupal->load(['reserva.espacio', 'alumnos']);
        $alumnos = Usuario::where('tipo_usuario', 'ALUMNO')->orderBy('name')->get();
        $alumnosSeleccionados = $reservasGrupal->alumnos->pluck('id')->toArray();

        return view('reservas-grupales.editar-miembros', compact('reservasGrupal', 'alumnos', 'alumnosSeleccionados'));
    }

    public function actualizarMiembros(Request $request, ReservaGrupal $reservasGrupal)
    {
        $request->validate([
            'alumnos'   => 'required|array|min:2|max:' . $reservasGrupal->aforo_max,
            'alumnos.*' => 'exists:usuarios,id',
        ]);

        $reservasGrupal->alumnos()->sync($request->alumnos);

        return redirect()->route('reservas.mias')
            ->with('success', 'Los miembros de la reserva grupal se han actualizado correctamente.');
    }
}
