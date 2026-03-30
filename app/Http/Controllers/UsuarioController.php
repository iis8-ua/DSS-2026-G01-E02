<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function perfil(){
        $usuario = Auth::user();

        $reservas = collect();

        if (str_contains(strtolower($usuario->tipo_usuario), 'alumno')) {
            $reservas = \App\Models\Reserva::with('espacio')
                ->where('alumno_id', $usuario->id)
                ->orderBy('hora_inicio', 'desc')
                ->get();
        }

        return view('usuario', [
            'usuario' => $usuario,
            'reservas' => $reservas,
        ]);
    }

    //funcion para listar a los usuarios en el admin
    public function index(Request $request){
        $query = Usuario::query();

        //para la busqueda por nombre, apellidos, email, dni
        if ($request->filled('buscar')) {
            $query->where('name', 'like', '%' . $request->input('buscar') . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->input('buscar') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('buscar') . '%')
                  ->orWhere('dni', 'like', '%' . $request->input('buscar') . '%');
        }

        //ordenación alfabeticamente por el nombre
        $campoOrden = $request->input('ordenar_por', 'name');
        $direccion = $request->input('direccion', 'asc');
        $query->orderBy($campoOrden, $direccion);

        //paginación, 10  por pagina y con el append no se pierde la busqueda y ordenacion al pasar de pagina
        $usuarios = $query->paginate(10)->appends($request->all());
        //devolver los datos a la vista
        return view('usuarios.index', compact('usuarios'));
    }
    //funcion editar usuario
    public function edit(Usuario $usuario){
        return view('usuarios.edit', ['usuario' => $usuario]);
    }
    public function updatePerfil(Request $request, Usuario $usuario){
        //validamos los datos y verificamos los dni
        $request->validate([
            'dni' => 'required|string|max:15|unique:usuarios,dni,' . $usuario->id,
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:6', // puede ser null
        ]);
        //se actualizan los datos
        $data = [
            'dni' => $request->dni,
            'name' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
        ];
        //si hay nueva contraseña se encripta y se añade
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $usuario->update($data);
        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }
    public function editPerfil(Usuario $usuario) {
        return view('usuarios.update-perfil', ['usuario' => $usuario]);
    }
    //funcion para update usuario
    public function update(Request $request, Usuario $usuario){
        //validamos los datos y verificamos los dni
        $request->validate([
            'dni' => 'required|string|max:15|unique:usuarios,dni,' . $usuario->id,
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:6', // puede ser null
            'tipo_usuario' => 'required|string|in:alumno,gestor_espacios',
        ]);
        //se actualizan los datos
        $data = [
            'dni' => $request->dni,
            'name' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'tipo_usuario' => $request->tipo_usuario,
        ];
        //si hay nueva contraseña se encripta y se añade
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $usuario->update($data);
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    //funcion para eliminar al usuario
    public function destroy(Usuario $usuario){
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
    // función para llamar a la vista de crear usuarios desde el Admin
    public function create(){
        return view('usuarios.create');
    }

    // método para guardar el usuario en la base de datos
    public function store(Request $request)
    {
        // validamos que los datos que llegan del formulario son correctos
        $request->validate([
            'dni' => 'required|string|max:15|unique:usuarios,dni',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'tipo_usuario' => 'required|string',
        ]);

        // creamos el usuario y asignamos los valores
        $usuario = new Usuario();
        $usuario->dni = $request->dni;
        
        $usuario->name = $request->nombre; 
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;

        // encriptamos la contraseña antes de guardarla
        $usuario->password = Hash::make($request->password); 
        $usuario->tipo_usuario = $request->tipo_usuario;
        
        // Guardamos en la base de datos
        $usuario->save();

        // redirigimos a la vista del admin con un mensaje
        return redirect()->route('usuarios.index')->with('success', 'Usuario añadido correctamente.');
    }
}
