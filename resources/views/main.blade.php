{{-- resources/views/main.blade.php --}}
@extends('layouts.master')

@section('title', 'Mapa interactivo')

@section('css')

@section('content')
    <main class="flex-1 flex overflow-hidden absolute w-full h-full">
        <x-notifications/>
        <x-map/>
    </main>
@endsection
