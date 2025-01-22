<template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <h1 class="text-4xl font-bold mb-6 text-center">Bienvenido</h1>
      <p class="text-center mb-8 text-lg">Selecciona una opción para gestionar las diferentes entidades de la aplicación.</p>
  
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Enlace a Tipos de Venta -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Tipos de Venta</h2>
          <p class="mb-4">Administra los tipos de venta disponibles.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/tipo-ventas')"
          >
            Ir a Tipos de Venta
          </button>
        </div>
  
        <!-- Enlace a Precios -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Precios</h2>
          <p class="mb-4">Gestiona los precios de productos y servicios.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/precio')"
          >
            Ir a Precios
          </button>
        </div>
  
        <!-- Enlace a Productos -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Productos</h2>
          <p class="mb-4">Gestiona los productos disponibles.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/producto')"
          >
            Ir a Productos
          </button>
        </div>
  
        <!-- Enlace a Prestaciones -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Prestaciones</h2>
          <p class="mb-4">Administra las prestaciones ofrecidas.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/prestacion')"
          >
            Ir a Prestaciones
          </button>
        </div>
  
        <!-- Enlace a Sucursales -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Sucursales</h2>
          <p class="mb-4">Gestiona las sucursales de tu negocio.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/sucursal')"
          >
            Ir a Sucursales
          </button>
        </div>
  
        <!-- Enlace a Tipos de Prestaciones -->
        <div class="bg-white shadow-md rounded-lg p-4 text-center">
          <h2 class="text-2xl font-semibold mb-4">Tipos de Prestaciones</h2>
          <p class="mb-4">Administra las categorías de prestaciones.</p>
          <button
            class="bg-blue-500 text-white px-6 py-2 rounded-lg"
            @click="navigateTo('/tipoprestacion')"
          >
            Ir a Tipos de Prestaciones
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      navigateTo(route) {
        // Deriva a las rutas de tus vistas Blade
        window.location.href = route;
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos adicionales */
  </style>
  