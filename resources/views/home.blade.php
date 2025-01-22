@extends('layouts.app')

@section('content')
    @vite('resources/js/app.js') <!-- Carga los scripts de Vite -->

    

    <!-- Aquí se montará tu aplicación Vue -->
    <div class="w-full" id="app"></div> 

@endsection

 </style>