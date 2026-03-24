<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Función auxiliar de validación
     */
    private function validarHorario(Request $request, $id = null)
    {
        $request->validate([
            'inicio' => 'required|date_format:H:i',
            'fin'    => 'required|date_format:H:i|after:inicio',
        ]);
    }

    /**
     * Funcion para leer
     */
    public function index(Request $request)
    {
        $query = Horario::query();

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('inicio', 'like', '%' . $busqueda . '%')
                ->orWhere('fin', 'like', '%' . $busqueda . '%');
        }

        $campoOrden = $request->input('ordenar_por', 'inicio');
        $direccion  = $request->input('direccion', 'asc');
        $query->orderBy($campoOrden, $direccion)->orderBy('fin', $direccion);

        $horarios = $query->paginate(10)->appends($request->all());

        $conteosEspacios = DB::table('espacio_horario')
            ->select('horario_id', DB::raw('count(*) as total'))
            ->groupBy('horario_id')
            ->pluck('total', 'horario_id');

        return view('horarios.index', compact('horarios', 'conteosEspacios'));
    }

    /**
     * Funcion para crear
     */
    public function create()
    {
        return view('horarios.create');
    }

    /**
     * Funcion para guardar
     */
    public function store(Request $request)
    {
        $this->validarHorario($request);

        $existe = Horario::where('inicio', $request->inicio)
            ->where('fin', $request->fin)
            ->exists();

        if ($existe) {
            return back()->withInput()->withErrors([
                'inicio' => 'Ya existe un horario con ese tramo horario.'
            ]);
        }

        Horario::create([
            'inicio' => $request->inicio,
            'fin'    => $request->fin,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

    /**
     * Funcion para editar un horario
     */
    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    /**
     * Función para actualizar un horario
     */
    public function update(Request $request, Horario $horario)
    {
        $this->validarHorario($request, $horario->id);

        $existe = Horario::where('inicio', $request->inicio)
            ->where('fin', $request->fin)
            ->where('id', '!=', $horario->id)
            ->exists();

        if ($existe) {
            return back()->withInput()->withErrors([
                'inicio' => 'Ya existe un horario con ese tramo horario.'
            ]);
        }

        $horario->update([
            'inicio' => $request->inicio,
            'fin'    => $request->fin,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    /**
     * Funcion para borrar un horario
     */
    public function destroy(Horario $horario)
    {
        //en la pivote esta restrict por lo que hay que controlar ese mensaje si lo esta usando un espacio no se puede eliminar
        $enUso = Espacio::whereHas('horario', function ($q) use ($horario) {
            $q->where('horarios.id', $horario->id);
        })->exists();

        if ($enUso) {
            return redirect()->route('horarios.index')->with('error', 'No se puede eliminar el horario porque está asignado a uno o más espacios.');
        }

        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }
}
