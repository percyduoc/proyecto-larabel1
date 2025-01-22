<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
    <h1 class="text-3xl font-bold text-center mb-6">Gestionar Sucursales</h1>

    <!-- Lista de Sucursales -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6  ">
          <!-- Botón para abrir el modal -->
    <button
      class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition"
      @click="openModal()"
    >
      Crear Nueva Sucursal
    </button>

      <h2 class="text-xl font-semibold mb-4">Lista de Sucursales</h2>
      <table class="w-full border-collapse border border-gray-300">
        <thead>
          <tr>
         
            <th class="border border-gray-300 p-2">Nombre</th>
            <th class="border border-gray-300 p-2">Región</th>
            <th class="border border-gray-300 p-2">Descripción</th>
            <th class="border border-gray-300 p-2">Estado</th>
            <th class="border border-gray-300 p-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="sucursal in sucursales" :key="sucursal.id">
    
            <td class="border border-gray-300 p-2">{{ sucursal.nombre }}</td>
            <td class="border border-gray-300 p-2">{{ sucursal.region }}</td>
            <td class="border border-gray-300 p-2">{{ sucursal.descripcion }}</td>
            <td class="border border-gray-300 p-2">
              {{ sucursal.estado ? 'Activo' : 'Inactivo' }}
            </td>
            <td class="border border-gray-300 p-2">
              <button
                class="text-yellow-200 px-2 py-1 mr-2"
                @click="openModal(sucursal)"
              >
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button
                class="text-red-600 px-2 py-1"
                @click="deleteSucursal(sucursal.id)"
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
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">
          {{ editing ? 'Editar Sucursal' : 'Crear Sucursal' }}
        </h2>
        <form @submit.prevent="saveSucursal" class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre:</label>
            <input
              v-model="form.nombre"
              type="text"
              placeholder="Nombre"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Región:</label>
            <input
              v-model="form.region"
              type="text"
              placeholder="Región"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Descripción:</label>
            <textarea
              v-model="form.descripcion"
              placeholder="Descripción"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
            ></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Estado:</label>
            <select
              v-model="form.estado"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
            >
              <option :value="1">Activo</option>
              <option :value="0">Inactivo</option>
            </select>
          </div>
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition"
            >
              Cancelar
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition"
            >
              {{ editing ? 'Actualizar' : 'Crear' }}
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
      sucursales: [],
      form: {
        id: null,
        nombre: "",
        region: "",
        descripcion: "",
        estado: true,
      },
      editing: false,
      showModal: false,
    };
  },
  methods: {
    fetchSucursales() {
      axios
        .get("/api/sucursales")
        .then((response) => (this.sucursales = response.data))
        .catch((error) => console.error("Error al obtener sucursales:", error));
    },
    saveSucursal() {
      const action = this.editing
        ? axios.put(`/api/sucursales/${this.form.id}`, this.form)
        : axios.post("/api/sucursales", this.form);

      action
        .then(() => {
          this.$swal.fire("¡Éxito!", "Sucursal guardada con éxito.", "success");
          this.fetchSucursales();
          this.closeModal();
        })
        .catch((error) =>
          console.error("Error al guardar la sucursal:", error)
        );
    },
    openModal(sucursal = null) {
      if (sucursal) {
        this.form = { ...sucursal };
        this.editing = true;
      } else {
        this.resetForm();
        this.editing = false;
      }
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    deleteSucursal(id) {
      this.$swal
        .fire({
          title: "¿Estás seguro?",
          text: "No podrás deshacer esta acción.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios.delete(`/api/sucursales/${id}`).then(() => {
              this.$swal.fire("¡Eliminado!", "La sucursal ha sido eliminada.", "success");
              this.fetchSucursales();
            });
          }
        });
    },
    resetForm() {
      this.form = {
        id: null,
        nombre: "",
        region: "",
        descripcion: "",
        estado: true,
      };
    },
  },
  mounted() {
    this.fetchSucursales();
  },
};
</script>

<style scoped>
/* Agrega tus estilos aquí */
</style>
