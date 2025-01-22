<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
    <h1 class="text-3xl font-bold mb-6 text-center">Gestión de Tipos de Venta</h1>

    <!-- Lista de Tipos de Venta -->
    <div class="mb-6 bg-white p-6 shadow-md rounded-md">
      <button
        class="mt-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md"
        @click="openModal()"
      >
        Crear Tipo de Venta
      </button>
      <h2 class="text-xl font-semibold mb-2">Lista de Tipos de Venta</h2>
      <table class="w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="p-3 text-left">Nombre</th>
            <th class="p-3 text-left">Estado</th>
            <th class="p-3 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tipoVenta in tipoVentas" :key="tipoVenta.id" class="hover:bg-gray-100">
            <td class="p-3 text-left">{{ tipoVenta.nombre }}</td>
            <td class="p-3 text-left">{{ tipoVenta.estado ? 'Activo' : 'Inactivo' }}</td>
            <td class="p-3 text-left ">
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
