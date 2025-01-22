<template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <h1 class="text-3xl font-bold mb-6 text-center">Gestión de Detalles de Ventas</h1>
  
      <!-- Lista de detalles -->
      <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
              <!-- Botón para abrir el formulario modal -->
      <button
        @click="openModal()"
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
      >
        Crear Nuevo Detalle
      </button>
        <h2 class="text-xl font-semibold mb-4">Lista de Detalles</h2>
        <table class="w-full border-collapse border border-gray-300">
          <thead>
            <tr>
              <th class="border border-gray-300 p-2">Cuenta</th>
              <th class="border border-gray-300 p-2">Producto</th>
              <th class="border border-gray-300 p-2">Cantidad</th>
              <th class="border border-gray-300 p-2">Valor</th>
              <th class="border border-gray-300 p-2">Estado</th>
              <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="detalle in detalles" :key="detalle.id" class="hover:bg-gray-100">
                <td class="border border-gray-300 p-2">{{ detalle.cuenta.nombre  }}</td>
                <td class="border border-gray-300 p-2">{{  detalle.producto.nombre  }}</td>

              <td class="border border-gray-300 p-2">{{ detalle.cantidad_producto }}</td>
              <td class="border border-gray-300 p-2">{{ detalle.valor_producto }}</td>
              <td class="border border-gray-300 p-2">{{ detalle.estado ? 'Activo' : 'Inactivo' }}</td>
              <td class="border border-gray-300 p-2">
                <button class="text-yellow-300 px-2 py-1 mr-2" @click="editDetalle(detalle)">
                  <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                </button>
                <button class="text-red-600 px-2 py-1" @click="deleteDetalle(detalle.id)">
                  <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  

  
      <!-- Modal de formulario -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-1/2">
          <h2 class="text-xl font-semibold mb-4">{{ editing ? 'Editar Detalle' : 'Crear Detalle' }}</h2>
          <form @submit.prevent="saveDetalle" class="space-y-4">
            <div>
              <label for="id_cuenta" class="block text-sm font-medium text-gray-700">Cuenta:</label>
              <select
                id="id_cuenta"
                v-model="form.id_cuenta"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              >
                <option v-for="cuenta in cuentas" :key="cuenta.id" :value="cuenta.id">{{ cuenta.nombre }}</option>
              </select>
            </div>
            <div>
              <label for="id_producto" class="block text-sm font-medium text-gray-700">Producto:</label>
              <select
                id="id_producto"
                v-model="form.id_producto"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              >
                <option v-for="producto in productos" :key="producto.codigo" :value="producto.codigo">{{ producto.nombre }}</option>
              </select>
            </div>
            <div>
              <label for="cantidad_producto" class="block text-sm font-medium text-gray-700">Cantidad:</label>
              <input
                id="cantidad_producto"
                v-model="form.cantidad_producto"
                type="number"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <div>
              <label for="valor_producto" class="block text-sm font-medium text-gray-700">Valor:</label>
              <input
                id="valor_producto"
                v-model="form.valor_producto"
                type="number"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <div>
              <label for="estado" class="block text-sm font-medium text-gray-700">Estado:</label>
              <select
                id="estado"
                v-model="form.estado"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              >
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
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
        props: ['id'], 
        detalles: [],
        cuentas: [],
        productos: [],
        form: {
          id_cuenta: '',
          id_producto: '',
          cantidad_producto: '',
          valor_producto: '',
          estado: 1, // Activo por defecto
        },
        editing: false,
        showModal: false,
      };
    },
    methods: {
      fetchDetalles() {
        axios.get('/api/detalles').then((response) => (this.detalles = response.data));
      },
      fetchCuentas() {
        axios.get('/api/cuentas').then((response) => 
        
        (this.cuentas = response.data));
       
      },
      fetchProductos() {
        axios.get('/api/productos').then((response) => (this.productos = response.data));
      },
      saveDetalle() {
        const action = this.editing
          ? axios.put(`/api/detalles/${this.form.id}`, this.form)
          : axios.post('/api/detalles', this.form);
  
        action.then(() => {
          this.$swal.fire('¡Éxito!', this.editing ? 'Actualizado correctamente.' : 'Creado correctamente.', 'success');
          this.fetchDetalles();
          this.resetForm();
          this.closeModal();
        }).catch((error) => {
          console.error('Error al guardar el detalle:', error);
          this.$swal.fire('Error', 'Hubo un problema al guardar el detalle.', 'error');
        });
      },
      editDetalle(detalle) {
        this.form = { ...detalle };
        this.editing = true;
        this.openModal();
      },
      deleteDetalle(id) {
        this.$swal.fire({
          title: '¿Estás seguro?',
          text: "¡Esta acción no se puede deshacer!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`/api/detalles/${id}`).then(() => {
              this.$swal.fire('¡Éxito!', 'Eliminado correctamente.', 'success');
              this.fetchDetalles();
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
        this.form = { id_cuenta: '', id_producto: '', cantidad_producto: '', valor_producto: '', estado: 1 };
        this.editing = false;
      },
      cancelEdit() {
        this.resetForm();
        this.closeModal();
      }
    },
    mounted() {
      this.fetchDetalles();
      this.fetchCuentas();
      this.fetchProductos();
    }
  };
  </script>
  