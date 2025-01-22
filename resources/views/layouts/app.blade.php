<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Proyecto Laravel</title>
    <!-- Rutas correctas a los archivos CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
     <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">
     <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.rtl.css') }}">
     <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.rtl.min.css') }}">
</head>
<body>
    <!-- Contenido aquí -->
    @yield('content')

    <!-- Scripts de AdminLTE -->
    <!-- <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script> -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    

</body>
</html>
<style>
   
</style>
