<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
    <header class="w-full bg-blue-600 text-white py-6 shadow-sm  ">
      <h1 class="text-4xl font-extrabold text-center">Tipos de prestaciones </h1>
      <p class="text-center mt-2">Gestiona todos tus tipos de prestacion </p>
    </header>

    <!-- Lista de tipos de prestación -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold mb-4">Lista de Tipos de Prestación</h2>
        <button
      class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-md"
      @click="openModal()"
    >
      Crear Nuevo Tipo de Prestación
    </button>

      
      </div>
      <div class="overflow-x-auto"> 
      <table class="w-full border-collapse border border-gray-300 text-sm">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-3 text-left ">Nombre</th>
            <th class="p-3 text-left ">Estado</th>
            <th class="p-3 text-left">Descripción</th>
            <th class="p-3 text-left ">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tipo in tipoPrestaciones" :key="tipo.id" class="hover:bg-gray-100">
            <td class="p-3 text-left">{{ tipo.nombre }}</td>
            <td class="p-3 text-left">{{ tipo.estado ? 'Activo' : 'Inactivo' }}</td>
            <td class="p-3 text-left">{{ tipo.descripcion }}</td>
            <td class="p-3 text-left ">
              <button
                class="text-yellow-200 hover:text-yellow-600 px-2"
                @click="openModal(tipo)"
              >
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button
                class="text-red-600 hover:text-red-800 px-2"
                @click="deleteTipo(tipo.id)"
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
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">
          {{ editing ? 'Editar Tipo de Prestación' : 'Crear Tipo de Prestación' }}
        </h2>
        <form @submit.prevent="saveTipoPrestacion" class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre:</label>
            <input
              v-model="form.nombre"
              type="text"
              @input="validateNombre"
              placeholder="Nombre"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Descripción:</label>
            <textarea
              v-model="form.descripcion"
              @input="validateDescripcion"
              placeholder="Descripción"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
            ></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Estado:</label>
            <select
              v-model="form.estado"
              default="true"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500"
            >
              <option :value="true">Activo</option>
              <option :value="false">Inactivo</option>
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
      tipoPrestaciones: [],
      form: {
        nombre: "",
        descripcion: "",
        estado: true,
      },
      editing: false,
      editingId: null,
      showModal: false, // Nuevo estado para controlar el modal
    };
  },
  methods: {
    validateNombre(){
      this.form.nombre = this.form.nombre.replace(/[^a-zA-Z0-9 ]/g, "");
    },
    validateDescripcion(){
      this.form.descripcion = this.form.descripcion.replace(/[^a-zA-Z0-9 ]/g, "");
    },
  

    fetchTiposPrestacion() {
      axios.get("/api/tipo-prestaciones").then((response) => {
        this.tipoPrestaciones = response.data;
      });
    },
    saveTipoPrestacion() {
      const action = this.editing
        ? axios.put(`/api/tipo-prestaciones/${this.editingId}`, this.form)
        : axios.post("/api/tipo-prestaciones", this.form);

      action
        .then(() => {
          this.$swal.fire("¡Éxito!", "Guardado correctamente.", "success");
          this.fetchTiposPrestacion();
          this.closeModal();
        })
        .catch((error) =>
          console.error("Error al guardar el tipo de prestación:", error)
        );
    },
    openModal(tipo = null) {
      if (tipo) {
        this.form = { ...tipo };
        this.editing = true;
        this.editingId = tipo.id;
      } else {
        this.resetForm();
        this.editing = false;
        this.editingId = null;
      }
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    deleteTipo(id) {
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
            axios.delete(`/api/tipo-prestaciones/${id}`).then(() => {
              this.$swal.fire("¡Eliminado!", "El tipo de prestación ha sido eliminado.", "success");
              this.fetchTiposPrestacion();
            });
          }
        });
    },
    resetForm() {
      this.form = { nombre: "", descripcion: "", estado: true };
    },
  },
  mounted() {
    this.fetchTiposPrestacion();
  },
};
</script>

<style scoped>
/* Agrega tus estilos personalizados aquí */
</style>
  