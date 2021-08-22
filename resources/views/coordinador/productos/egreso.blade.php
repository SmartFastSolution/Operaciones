@extends('layouts.nav')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-arrow-circle-right"></i> Egresos</li>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('bodega', 'active')
@section('egresos', 'active')
@section('content')
@section('titulo', '| Egresos')
<div>
    <h1 class="text-danger text-center">EGRESOS</h1>
    @livewire('coordinador.producto.egresos')
</div>
@endsection
@section('js')

@endsection
