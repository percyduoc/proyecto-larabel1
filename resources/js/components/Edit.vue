<template>
  <div class="  p-6 bg-gray-100 min-h-screen items-center justify-center w-full">
      <h1 class="text-3xl font-semibold mb-6 text-center">Editar Producto</h1>
      <form @submit.prevent="updateItem">
          <!-- Nombre -->
          <div class="mb-4">
              <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
              <input
                  id="nombre"
                  type="text"
                  v-model="form.nombre"
                  placeholder="Nombre"
                  required
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
          </div>

          <!-- Código -->
          <div class="mb-4">
              <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
              <input
                  id="codigo"
                  type="text"
                  v-model="form.codigo"
                  placeholder="Código"
                  required
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
          </div>

          <!-- Valor -->
          <div class="mb-4">
              <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
              <input
                  id="valor"
                  type="number"
                  v-model="form.valor"
                  placeholder="Valor"
                  required
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
          </div>

          <!-- Estado -->
          <div class="mb-4">
              <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
              <select
                  id="estado"
                  v-model="form.estado"
                  required
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                  <option :value="1">Activo</option>
                  <option :value="0">Inactivo</option>
              </select>
          </div>

          <!-- Descripción -->
          <div class="mb-6">
              <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
              <input
                  id="descripcion"
                  type="text"
                  v-model="form.descripcion"
                  placeholder="Descripción"
                  required
                  class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
          </div>

          <!-- Botón de actualización -->
          <button
              type="submit"
              class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
              Actualizar
          </button>
      </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
      return {
          form: {
              nombre: '',
              codigo: '',
              valor: null,
              estado: true,
              descripcion: '',
          },
      };
  },
  methods: {
      fetchData() {
          axios.get(`/api/productos/${this.$route.params.id}`).then((response) => {
              this.form = response.data;  // Asume que la respuesta tiene los campos correctos
          });
      },
      updateItem() {
        this.$swal.fire('¡Éxito!', 'Todo ha ido bien.', 'success');
          axios.patch(`/api/productos/${this.$route.params.id}`, this.form)
              .then(() => {
                  this.$router.push('/producto');  // Redirige después de la actualización
              })
              .catch((error) => {
                  console.error(error.response.data);
                  alert("Error al actualizar el producto");
              });
      },
  },
  mounted() {
      this.fetchData();  // Obtienes los datos al montar el componente
  },
};
</script>

