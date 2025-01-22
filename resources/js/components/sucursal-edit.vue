<template>
    <div class=" p-6 bg-gray-100 min-h-screen items-center justify-center w-full">
      <div class="bg-white p-6  rounded-lg w-full">
        <h1 class="text-3xl font-bold mb-6 text-center">Editar Sucursal</h1>
  
        <!-- Formulario para editar la sucursal -->
        <form @submit.prevent="updateSucursal" class="space-y-4">
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input
              type="text"
              id="nombre"
              v-model="form.nombre"
              placeholder="Nombre de la sucursal"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <div>
            <label for="region" class="block text-sm font-medium text-gray-700">Región</label>
            <input
              type="text"
              id="region"
              v-model="form.region"
              placeholder="Región de la sucursal"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
  
          <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea
              id="descripcion"
              v-model="form.descripcion"
              placeholder="Descripción de la sucursal"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>
  
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <select
              v-model="form.estado"
              id="estado"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
  
          <button
            type="submit"
            class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
          >
            Actualizar Sucursal
          </button>
        </form>
  
        <p v-if="errorMessage" class="mt-4 text-red-500 text-center">{{ errorMessage }}</p>
      </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          nombre: '',
          region: '',
          descripcion: '',
          estado: true,
        },
        errorMessage: '',
      };
    },
    methods: {
      // Obtener los detalles de la sucursal al editar
      fetchSucursal() {
        const { id } = this.$route.params;
        axios.get(`/api/sucursales/${id}`)
          .then((response) => {
            this.form = response.data;
          })
          .catch((error) => {
            console.error('Error al obtener la sucursal:', error);
            this.errorMessage = 'Error al obtener los datos de la sucursal.';
          });
      },
  
      // Actualizar la sucursal
      updateSucursal() {
        const { id } = this.$route.params;
        axios.put(`/api/sucursales/${id}`, this.form)
          .then(() => {
            this.$swal.fire('¡Éxito!', 'Todo ha ido bien.', 'success');
            this.$router.push('/sucursal'); // Redirigir a la lista de sucursales
          })
          .catch((error) => {
            this.$swal.fire('Error', 'Todo ha ido bien.', 'success');
            console.error('Error al actualizar la sucursal:', error);
            this.errorMessage = 'Error al actualizar la sucursal.';
          });
      },
    },
    mounted() {
      this.fetchSucursal(); // Llamar a la función cuando se monte el componente
    },
  };
  </script>
  
  <style scoped>
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  label {
    font-weight: bold;
  }
  
  input, textarea, select {
    padding: 0.5rem;
    font-size: 1rem;
  }
  
  button {
    background-color: #4CAF50;
    color: white;
    padding: 1rem;
    border: none;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #45a049;
  }
  
  .text-red-500 {
    color: #f87171;
  }
  </style>
  