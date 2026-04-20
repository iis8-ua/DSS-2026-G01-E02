<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\ReservaGrupal;
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

        $reservaGrupal = ReservaGrupal::create([
            'reserva_id' => $request->reserva_id,
            'aforo_max'  => $request->aforo_max,
        ]);

        if ($request->filled('alumnos')) {
            $reservaGrupal->alumnos()->sync($request->alumnos);
        }

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
        $reservasGrupal->alumnos()->detach();
        $reservasGrupal->delete();

        return redirect()->route('reservas-grupales.index')->with('success', 'Reserva grupal eliminada del sistema.');
    }
}
