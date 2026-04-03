@extends('layouts.master')

@section('title', 'Accesibilidad - EspaciUA')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background-color: #003366;">
            <h1 class="h4 mb-0"><i class="bi bi-universal-access"></i> Accesibilidad</h1>
        </div>
        <div class="card-body p-4">
            <h5 class="text-primary mt-3">Declaración de Accesibilidad</h5>
            <p>El equipo de desarrollo de "EspaciUA" se ha comprometido a hacer accesible su sitio web, de conformidad con el Real Decreto 1112/2018, de 7 de septiembre, sobre accesibilidad de los sitios web y aplicaciones para dispositivos móviles del sector público.</p>

            <h5 class="text-primary mt-4">Situación de Cumplimiento</h5>
            <p>Este sitio web es parcialmente conforme con las pautas WCAG 2.1. Se han implementado medidas como:</p>
            <ul>
                <li>Contraste adecuado de colores institucionales.</li>
                <li>Navegación clara y menús adaptables a dispositivos móviles (Responsive Design).</li>
                <li>Identificación clara de formularios de login y tablas de reservas.</li>
            </ul>
            <p>Seguimos trabajando para mejorar la experiencia de todos los usuarios de la comunidad universitaria.</p>
        </div>
    </div>
</div>
@endsection
