<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full">
    <header class="w-full bg-blue-600 text-white py-6 shadow-sm  ">
      <h1 class="text-4xl font-extrabold text-center">Precios</h1>
      <p class="text-center mt-2">Gestiona tus precios </p>
    </header>

    <!-- Lista de precios -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold mb-4">Lista de Precios</h2>
        <button @click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-md">
    Crear Precio
  </button>
    
    </div>
    <div class="overflow-x-auto">
      <table class="w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="p-3 text-left">Prestación</th>
            <th class="p-3 text-left">Valor</th>
            <th class="p-3 text-left">Fecha Desde</th>
            <th class="p-3 text-left">Fecha Hasta</th>
            <th class="p-3 text-left">Estado</th>
            <th class="p-3 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="precio in precios" :key="precio.id">
            <td class="p-3 text-left">{{ precio.prestaciones?.nombre }}</td>
            <td class="p-3 text-left">{{ precio.valor }}</td>
            <td class="p-3 text-left">{{ precio.fecha_desde }}</td>
            <td class="p-3 text-left">{{ precio.fecha_hasta || 'N/A' }}</td>
            <td class="p-3 text-left">{{ precio.estado ? 'Activo' : 'Inactivo' }}</td>
            <td class="p-3 text-left">
              <button class="text-yellow-200 px-2 py-1 mr-2" @click="editPrecio(precio)">
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button class="text-red-600 px-2 py-1" @click="deletePrecio(precio.id)">
                <font-awesome-icon :icon="['fas', 'trash']" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
    </div>
    </div>
    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50">
     
      <div class="w-1/2 justify-center items-center p-6 bg-white rounded-lg shadow-md">
       
        <h2 class="text-2xl font-bold mb-6 text-center">{{ editing ? 'Editar Precio' : 'Crear Precio' }}</h2>
        <form @submit.prevent="savePrecio" class="space-y-6">

          <div>
            <label for="prestacion" class="block text-sm font-medium text-gray-700">Prestación:</label>
            <select v-model="form.id_prestaciones" id="prestacion" required>
          <option v-for="prestacion in prestaciones" :key="prestacion.codigo" :value="prestacion.codigo">
              {{ prestacion.nombre }}
           </option>
         </select>
          </div>
          <div>
            <label for="valor" class="block text-sm font-medium text-gray-700">Valor:</label>
            <input type="number" v-model="form.valor" id="valor" min="0"  required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
          <div>
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha Desde:</label>
            <input
              type="date"
              v-model="form.fecha_desde"
              id="fecha_desde"
              required
              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              @change="updateFechaHasta"
            />
          </div>

          <div>
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha Hasta:</label>
            <input
              type="date"
              v-model="form.fecha_hasta"
              id="fecha_hasta"
              :min="form.fecha_desde"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
          </div>
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
            <select v-model="form.estado" id="estado" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option :value="1">Activo</option>
              <option :value="0">Inactivo</option>
            </select>
          </div>
          <div class="flex justify-end space-x-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ editing ? 'Actualizar' : 'Guardar' }}</button>
            <button type="button" @click="cancelEdit" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
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
      precios: [],
      prestaciones: [],
      form: {
        id_producto: '',
        id_prestaciones: '',
        valor: '',
        fecha_desde: '',
        fecha_hasta: '',
        estado: true,
      },
      editing: false,
      isModalOpen: false, // Controla la visibilidad del modal
    };
  },
  methods: {

    fetchPrecios() {
      axios.get('/api/precios').then((response) => (this.precios = response.data));
    },
    fetchPrestaciones() {
      axios.get('/api/prestaciones').then((response) => (this.prestaciones = response.data));
    },
    savePrecio() {
      const action = this.editing
        ? axios.put(`/api/precios/${this.form.id}`, this.form)
        : axios.post('/api/precios', this.form);

      action.then(() => {
        this.fetchPrecios();
        this.resetForm();
        this.closeModal(); // Cerrar el modal después de guardar
      });
    },
    editPrecio(precio) {
      this.form = { ...precio };
      this.editing = true;
      this.openModal(); // Abrir modal al editar
    },
    deletePrecio(id) {
      axios.delete(`/api/precios/${id}`).then(() => this.fetchPrecios());
    },
    cancelEdit() {
      this.resetForm();
      this.closeModal(); // Cerrar modal al cancelar
    },
    resetForm() {
      this.form = {
        id_prestacion: '',
        valor: '',
        fecha_desde: '',
        fecha_hasta: '',
        estado: true,
      };
      this.editing = false;
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
  },
  mounted() {
    this.fetchPrecios();

    this.fetchPrestaciones();
  },
};
</script>

<style scoped>
/* Puedes agregar más estilos aquí si es necesario */
</style>
