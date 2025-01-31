<template>
  <div class="bg-gray-50 min-h-screen items-center">
    <!-- Título -->
    <header class="w-full bg-blue-600 text-white py-6 shadow-sm  ">
      <h1 class="text-4xl font-extrabold text-center">Bienvenido </h1>
      <p class="text-center mt-2">Gestiona todos tus servicios en un solo lugar</p>
    </header>

    <!-- Dashboard Principal -->
    <div class="w-full max-w-7xl mx-auto p-1 mt-1 ">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Panel de Estadísticas -->
        <div class="bg-white shadow-lg rounded-lg p-6  items-center justify-between">
          <h3 class="text-2xl font-semibold mb-4">Cuentas Creadas</h3>
          <div class="text-4xl font-bold text-blue-600">
            {{ totalCuentas }}
          </div>
          <button 
            @click="navigateTo('/cuentas')" 
            class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition-all duration-200">
            Ver Cuentas
          </button>
        </div>

        <!-- Enlace a Tipos de Venta -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-2xl font-semibold mb-4">Tipos de Venta</h2>
          <p class="mb-4">Administra los tipos de venta disponibles.</p>
          <button 
            @click="navigateTo('/tipo-ventas')" 
            class="w-full py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200"
          >
            Ir a Tipos de Venta
          </button>
        </div>

        <!-- Enlace a Precios -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-2xl font-semibold mb-4">Precios</h2>
          <p class="mb-4">Gestiona los precios de productos y servicios.</p>
          <button 
            @click="navigateTo('/precio')" 
            class="w-full py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200"
          >
            Ir a Precios
          </button>
        </div>

        <!-- Enlace a Productos -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-2xl font-semibold mb-4">Categorias</h2>
          <p class="mb-4">Gestiona las categorias disponibles.</p>
          <button 
            @click="navigateTo('/tipoprestacion')" 
            class="w-full py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200"
          >
            Ir a Categorias
          </button>
        </div>

        <!-- Enlace a Sucursales -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-2xl font-semibold mb-4">Sucursales</h2>
          <p class="mb-4">Gestiona las sucursales de tu negocio.</p>
          <button 
            @click="navigateTo('/sucursal')" 
            class="w-full py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200"
          >
            Ir a Sucursales
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cuentas: [],  // Aquí se almacenarán las cuentas
      totalCuentas: 0,  // Aquí se almacenará la cantidad de cuentas
    };
  },
  mounted() {
    this.fetchCuentasCount();
    console.log(this.fetchCuentasCount());  
  },
  methods: {
      async fetchCuentasCount() {
        axios
      .get('/api/cuentas')
      .then((response) => {
        this.cuentas = response.data;
        this.totalCuentas = this.cuentas.length;
      })
      .catch((error) => {
        console.error('Error al obtener cuentas:', error);
      });
    },
      navigateTo(route) {
      this.$router.push(route);
    }

  },  


};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
