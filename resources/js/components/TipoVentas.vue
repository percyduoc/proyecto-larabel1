<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
     
    <header class="w-full  bg-blue-600 text-white py-6 shadow-sm  ">
      <h1 class="text-4xl font-extrabold text-center">Ventas </h1>
      <p class="text-center mt-2">Gestiona todos tus Ventas </p>
    </header>

    <!-- Lista de Tipos de Venta -->
    <div class="mb-6 bg-white p-6 shadow-md rounded-md">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold mb-2">Lista de Tipos de Venta</h2>
        <button
        class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-md"
        @click="openModal()"
      >
        Crear Ventas
      </button>
    
      </div>
      <div class="overflow-x-auto"> 
      <table class="w-full border-collapse odd:bg-gray-50 even:bg-white hover:bg-gray-100">
        <thead>
          <tr class="bg-gray-200 text-gray-700">
            <th class="p-3 text-left">Nombre</th>
            <th class="p-3 text-left">Estado</th>
            <th class="p-3 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tipoVenta in tipoVentas" :key="tipoVenta.id" class="odd:bg-gray-50 even:bg-white hover:bg-gray-100">
            <td class="p-3 text-gray-800">{{ tipoVenta.nombre }}</td>
            <td class="p-3 text-gray-800">{{ tipoVenta.estado ? 'Activo' : 'Inactivo' }}</td>
            <td class="p-3 text-gray-800">
              <button
                class="text-yellow-200 hover:text-yellow-600 px-2"
                @click="openModal(tipoVenta)"
              >
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button
                class="text-red-600 hover:text-red-800 px-2"
                @click="deleteTipoVenta(tipoVenta.id)"
              >
                <font-awesome-icon :icon="['fas', 'trash']" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">
          {{ editing ? 'Editar Tipo de Venta' : 'Crear Tipo de Venta' }}
        </h2>
        <form @submit.prevent="saveTipoVenta" class="space-y-6">
          <!-- Campo Nombre -->
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
            <input
              type="text"
              v-model="form.nombre"
              @input="validateNombre"
              id="nombre"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="Ingrese el nombre"
            />
          </div>

          <!-- Campo Estado -->
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
            <select
              v-model="form.estado"
              id="estado"
              required
              default="1"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            >
              <option :value="1">Activo</option>
              <option :value="0">Inactivo</option>
            </select>
          </div>

          <!-- Botones -->
          <div class="flex space-x-4">
            <button
              type="submit"
              class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md"
            >
              {{ editing ? 'Actualizar' : 'Guardar' }}
            </button>
            <button
              type="button"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
              @click="closeModal"
            >
              Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      tipoVentas: [],
      form: {
        nombre: "",
        estado: true,
      },
      editing: false,
      editingId: null,
      showModal: false, // Control del modal
    };
  },
  methods: {
    validateNombre() {
    this.form.nombre = this.form.nombre.replace(/[^a-zA-Z0-9 ]/g, "");
     
    },
    fetchTipoVentas() {
      axios.get("/api/tipo-ventas").then((response) => {
        this.tipoVentas = response.data;
      });
    },
    saveTipoVenta() {
      const action = this.editing
        ? axios.put(`/api/tipo-ventas/${this.editingId}`, this.form)
        : axios.post("/api/tipo-ventas", this.form);

      action.then(() => {
        this.$swal.fire("¡Éxito!", "Operación realizada correctamente.", "success");
        this.fetchTipoVentas();
        this.closeModal();
      });
    },
    openModal(tipoVenta = null) {
      if (tipoVenta) {
        this.editing = true;
        this.editingId = tipoVenta.id;
        this.form = { ...tipoVenta };
      } else {
        this.editing = false;
        this.resetForm();
      }
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    deleteTipoVenta(id) {
      this.$swal.fire("¡Éxito!", "Eliminado correctamente.", "success");
      axios.delete(`/api/tipo-ventas/${id}`).then(() => this.fetchTipoVentas());
    },
    resetForm() {
      this.form = { nombre: "", estado: true };
      this.editingId = null;
    },
  },
  mounted() {
    this.fetchTipoVentas();
  },
};
</script>

<style scoped>
/* Agrega tus estilos aquí */
</style>
