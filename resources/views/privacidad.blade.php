@extends('layouts.master')

@section('title', 'Protección de Datos - EspaciUA')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background-color: #003366;">
            <h1 class="h4 mb-0"><i class="bi bi-shield-lock"></i> Política de Privacidad y Protección de Datos</h1>
        </div>
        <div class="card-body p-4">
            <h5 class="text-primary mt-3">1. Responsable del Tratamiento</h5>
            <p>A efectos de este proyecto académico, la gestión de los datos recae sobre los administradores del sistema "EspaciUA", actuando bajo el marco de simulación de la Universidad de Alicante.</p>

            <h5 class="text-primary mt-4">2. Datos Recopilados y Finalidad</h5>
            <p>Para el uso del sistema, se recopilan los siguientes datos de carácter personal: Nombre, Apellidos, DNI, Correo Electrónico y Rol (Alumno, Profesor, PAS/PDI). Estos datos se utilizan exclusivamente con la finalidad de gestionar la reserva de aulas, laboratorios y otros espacios de la universidad, así como para el envío de notificaciones sobre el estado de dichas reservas.</p>

            <h5 class="text-primary mt-4">3. Derechos de los Usuarios</h5>
            <p>En cumplimiento del Reglamento General de Protección de Datos (RGPD), el usuario tiene derecho a acceder, rectificar, limitar y suprimir sus datos en cualquier momento accediendo a su perfil de usuario o contactando con el soporte del sistema.</p>
        </div>
    </div>
</div>
@endsection
