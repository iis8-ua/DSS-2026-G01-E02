{{-- resources/views/create-usuarios.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Usuario</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback por si falla Vite --}}
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800 font-sans">

    {{-- Cabecera --}}
    <header class="bg-white border-b border-gray-200 shadow-sm px-8 py-5 flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 w-8 h-8 rounded flex items-center justify-center text-white font-bold">A</div>
            <h1 class="text-2xl font-bold text-gray-800">Añadir Nuevo Usuario</h1>
        </div>
        <a href="{{ route('admin') }}" class="text-gray-500 hover:text-gray-800 font-medium text-sm transition-colors">
            &larr; Volver al panel
        </a>
    </header>

    <main class="flex-1 p-8 flex justify-center items-start">
        {{-- Contenedor del formulario --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 w-full max-w-2xl mt-4">
            
            {{-- guardamos el formulario con la funcion store de UsuarioController --}}
            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
                {{-- obligatorio por seguridad --}}
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- DNI --}}
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('dni') border-red-500 @enderror">
                        @error('dni')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- Apellidos --}}
                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('apellidos') border-red-500 @enderror">
                        @error('apellidos')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('email') border-red-500 @enderror">
                        @error('email')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('password') border-red-500 @enderror">
                        @error('password')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tipo de usuario --}}
                    <div>
                        <label for="tipo_usuario" class="block text-sm font-medium text-gray-700 mb-1">Rol del Usuario</label>
                        <select name="tipo_usuario" id="tipo_usuario" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white @error('tipo_usuario') border-red-500 @enderror">
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="alumno" {{ old('tipo_usuario') == 'alumno' ? 'selected' : '' }}>Alumno</option>
                            <option value="profesor" {{ old('tipo_usuario') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                            <option value="admin" {{ old('tipo_usuario') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('tipo_usuario')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Botones para cancelar o guardar --}}
                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors px-4 py-2">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                        Guardar Usuario
                    </button>
                </div>
            </form>

        </section>
    </main>

</body>
</html>