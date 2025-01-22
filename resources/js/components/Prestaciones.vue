<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
    <h1 class="text-3xl font-bold mb-6 text-center">Gestión de Prestaciones</h1>

    <!-- Lista de prestaciones -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-">
      <button
      @click="openModal()"
      class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
    >
      Crear Nueva Prestación
    </button>
      <h2 class="text-xl font-semibold mb-4">Lista de Prestaciones</h2>
      
      <table class="w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="border border-gray-300 p-2">Código</th>
            <th class="border border-gray-300 p-2">Nombre</th>
            <th class="border border-gray-300 p-2">Tipo de Prestación</th>
            <th class="border border-gray-300 p-2">Valor</th>
            <th class="border border-gray-300 p-2">Estado</th>
            <th class="border border-gray-300 p-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="prestacion in prestaciones" :key="prestacion.codigo" class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2">{{ prestacion.codigo }}</td>
            <td class="border border-gray-300 p-2">{{ prestacion.nombre }}</td>
            <td class="border border-gray-300 p-2">{{ prestacion.tipo_prestacion?.nombre }}</td>
            <td class="border border-gray-300 p-2">{{ prestacion.valor }}</td>
            <td class="border border-gray-300 p-2">{{ prestacion.estado ? 'Activo' : 'Inactivo' }}</td>
            <td class="border border-gray-300 p-2">
              <button class="text-yellow-200 px-2 py-1 mr-2" @click="editPrestacion(prestacion)">
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button class="text-red-600 px-2 py-1" @click="deletePrestacion(prestacion.codigo)">
                <font-awesome-icon :icon="['fas', 'trash']" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Botón para abrir el formulario modal -->
  

    <!-- Modal de formulario -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg w-1/2">
        <h2 class="text-xl font-semibold mb-4">{{ editing ? 'Editar Prestación' : 'Crear Prestación' }}</h2>
        <form @submit.prevent="savePrestacion" class="space-y-4">
          <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código:</label>
            <input
              id="codigo"
              v-model="form.codigo"
              :disabled="editing"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input
              id="nombre"
              v-model="form.nombre"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="tipoPrestacion" class="block text-sm font-medium text-gray-700">Tipo de Prestación:</label>
            <select
              id="tipoPrestacion"
              v-model="form.tipo_prestacion_id"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option v-for="tipo in tiposPrestacion" :key="tipo.id" :value="tipo.id">{{ tipo.nombre }}</option>
            </select>
          </div>
          <div>
            <label for="valor" class="block text-sm font-medium text-gray-700">Valor:</label>
            <input
              type="number"
              id="valor"
              v-model="form.valor"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
            <select
              id="estado"
              v-model="form.estado"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option :value="1">Activo</option>
              <option :value="0">Inactivo</option>
            </select>
          </div>
          <div class="flex items-center space-x-2">
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
            >
              {{ editing ? 'Actualizar' : 'Guardar' }}
            </button>
            <button
              v-if="editing"
              type="button"
              @click="cancelEdit"
              class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
            >
              Cancelar
            </button>
            <button
              type="button"
              @click="closeModal"
              class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
            >
              Cerrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      prestaciones: [],
      tiposPrestacion: [],
      form: {
        codigo: '',
        nombre: '',
        tipo_prestacion_id: '',
        valor: '',
        estado: true,
      },
      editing: false,
      showModal: false,
    };
  },
  methods: {
    fetchPrestaciones() {
      axios.get('/api/prestaciones').then((response) => (this.prestaciones = response.data));
    },
    fetchTiposPrestacion() {
      axios.get('/api/tipo-prestaciones').then((response) => (this.tiposPrestacion = response.data));
    },
    savePrestacion() {
      const action = this.editing
        ? axios.put(`/api/prestaciones/${this.form.codigo}`, this.form)
        : axios.post('/api/prestaciones', this.form);

      action.then(() => {
        this.$swal.fire('¡Éxito!', this.editing ? 'Actualizado correctamente.' : 'Creado correctamente.', 'success');
        this.fetchPrestaciones();
        this.resetForm();
        this.closeModal();
      });
    },
    editPrestacion(prestacion) {
      this.form = { ...prestacion };
      this.editing = true;
      this.openModal();
    },
    deletePrestacion(codigo) {
      this.$swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/prestaciones/${codigo}`).then(() => {
            this.$swal.fire('¡Éxito!', 'Eliminado correctamente.', 'success');
            this.fetchPrestaciones();
          });
        }
      });
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    resetForm() {
      this.form = { codigo: '', nombre: '', tipo_prestacion_id: '', valor: '', estado: true };
      this.editing = false;
    },
    cancelEdit() {
      this.resetForm();
      this.closeModal();
    },
  },
  mounted() {
    this.fetchPrestaciones();
    this.fetchTiposPrestacion();
  },
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
