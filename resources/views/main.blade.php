{{-- resources/views/main.blade.php --}}
@extends('layouts.master')

@section('title', 'Mapa interactivo')

@section('css')

@section('content')
    <main>
        <x-notifications :notifications="$notifications"/>
        <x-map :markers="$markers"/>
    </main>
@endsection
