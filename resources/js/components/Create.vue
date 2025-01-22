<template>
    <div class="p-6 bg-gray-100 min-h-screen items-center justify-center w-full">
      <div class="bg-white p-6 shadow-lg rounded-lg ">
        <h1 class="text-3xl font-bold mb-6 text-center">Crear Producto</h1>
  
        <form @submit.prevent="createProducto" class="space-y-4">
          <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código:</label>
            <input
              type="text"
              id="codigo"
              v-model="producto.codigo"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
  
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input
              type="text"
              id="nombre"
              v-model="producto.nombre"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
  
          <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
            <textarea
              id="descripcion"
              v-model="producto.descripcion"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>
  
          <div>
            <label for="valor" class="block text-sm font-medium text-gray-700">Valor:</label>
            <input
              type="number"
              id="valor"
              v-model="producto.valor"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
  
          <div>
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha Desde:</label>
            <input
              type="date"
              id="fecha_desde"
              v-model="producto.fecha_desde"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
  
          <div>
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha Hasta:</label>
            <input
              type="date"
              id="fecha_hasta"
              v-model="producto.fecha_hasta"
              
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
  
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
            <select
              id="estado"
              v-model="producto.estado"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option :value="true">Activo</option>
              <option :value="false">Inactivo</option>
            </select>
          </div>
  
          <div class="flex justify-between items-center">
            <button
              type="submit"
              class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
              Guardar
            </button>
            <button
              type="button"
              @click="goBack"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
            >
              Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        producto: {
          codigo: "",
          nombre: "",
          descripcion: "",
          valor: null,
          fecha_desde: "",
          fecha_hasta: "",
          estado: true,
        },
      };
    },
    methods: {
      async createProducto() {
        try {
          
          const response = await axios.post("/api/productos", this.producto);
          this.$swal.fire('¡Éxito!', 'Todo ha ido bien.', 'success');
          this.$router.push({ name: "List" }); // Redirige a la lista después de crear
        } catch (error) {
          if (error.response && error.response.data.errors) {
            this.$swal.fire('¡error!', 'En la validacion.'
             + JSON.stringify(error.response.data.errors, null, 2));
            // alert("Errores de validación:\n" + JSON.stringify(error.response.data.errors, null, 2));
          } else {
            alert("Error al crear el producto.");
          }
        }
      },
      goBack() {
        this.$router.push({ name: "List" }); // Redirige a la lista si cancelas
      },
    },
  };
  </script>
  