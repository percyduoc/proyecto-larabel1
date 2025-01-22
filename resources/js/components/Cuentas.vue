<template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <h1 class="text-3xl font-bold mb-6 text-center">Gestión de Cuentas</h1>
  
      <!-- Lista de cuentas -->
      <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
        <button
        @click="openModal()"
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
      >
        Crear Nueva Cuenta
      </button>
        <h2 class="text-xl font-semibold mb-4">Lista de Cuentas</h2>
        <table class="w-full border-collapse border border-gray-300">
          <thead>
            <tr>
              <th class="border border-gray-300 p-2">Nombre</th>
              <th class="border border-gray-300 p-2">Dirección</th>
              <th class="border border-gray-300 p-2">Sucursal</th>
              <th class="border border-gray-300 p-2">Tipo de Venta</th>
              <th class="border border-gray-300 p-2">Estado</th> <!-- Agregado estado -->
              <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cuenta in cuentas" :key="cuenta.id" class="hover:bg-gray-100">
              <td class="border border-gray-300 p-2">{{ cuenta.nombre }}</td>
              <td class="border border-gray-300 p-2">{{ cuenta.direccion }}</td>
              <td class="border border-gray-300 p-2">{{ cuenta.sucursal ? cuenta.sucursal.nombre : '' }}</td>
              <td class="border border-gray-300 p-2">{{ cuenta.tipo_venta ? cuenta.tipo_venta.nombre : '' }}</td>
              <td class="border border-gray-300 p-2">{{ cuenta.estado ? 'Activo' : 'Inactivo' }}</td> <!-- Mostrar estado -->
              <td class="border border-gray-300 p-2">
                
                <button class="text-yellow-200 px-2 py-1 mr-2" @click="editCuenta(cuenta)">
                  <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                </button>
                <button class="text-blue-200 px-2 py-1 mr-2" @click="goToCuentaDetalle(cuenta.id)">
                  <font-awesome-icon :icon="['fas', 'eye']" />
                </button>
                <button class="text-red-600 px-2 py-1" @click="deleteCuenta(cuenta.id)">
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
          <h2 class="text-xl font-semibold mb-4">{{ editing ? 'Editar Cuenta' : 'Crear Cuenta' }}</h2>
          <form @submit.prevent="saveCuenta" class="space-y-4">
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
              <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección:</label>
              <input
                id="direccion"
                v-model="form.direccion"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <div>
              <label for="sucursal_id" class="block text-sm font-medium text-gray-700">Sucursal:</label>
              <select
                id="sucursal_id"
                v-model="form.sucursal_id"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              >
                <option v-for="sucursal in sucursales" :key="sucursal.id" :value="sucursal.id">{{ sucursal.nombre }}</option>
              </select>
            </div>
            <div>
              <label for="tipo_venta_id" class="block text-sm font-medium text-gray-700">Tipo de Venta:</label>
              <select
                id="tipo_venta_id"
                v-model="form.tipo_venta_id"
                required
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
              >
                <option v-for="tipoVenta in tipoVentas" :key="tipoVenta.id" :value="tipoVenta.id">{{ tipoVenta.nombre }}</option>
              </select>
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
        cuentas: [],
        sucursales: [],
        tipoVentas: [],
        form: {
          nombre: '',
          direccion: '',
          sucursal_id: '',
          tipo_venta_id: '',
          estado: 'activo', // Valor por defecto
        },
        editing: false,
        showModal: false,
      };
    },
    methods: {
      fetchCuentas() {
        axios.get('/api/cuentas').then((response) => (this.cuentas = response.data));
      },
      fetchSucursales() {
        axios
          .get("/api/sucursales")
          .then((response) => (this.sucursales = response.data))
          .catch((error) => console.error("Error al obtener sucursales:", error));
      },
      fetchTipoVentas() {
        axios.get('/api/tipo-ventas').then((response) => (this.tipoVentas = response.data));
      },
      saveCuenta() {
        const action = this.editing
          ? axios.put(`/api/cuentas/${this.form.id}`, this.form)
          : axios.post('/api/cuentas', this.form);
  
        action.then(() => {
          this.$swal.fire('¡Éxito!', this.editing ? 'Actualizado correctamente.' : 'Creado correctamente.', 'success');
          this.fetchCuentas();
          this.resetForm();
          this.closeModal();
        }).catch((error) => {
          console.error('Error al guardar la cuenta:', error);
          this.$swal.fire('Error', 'Hubo un problema al guardar la cuenta.'+error.response.data.message, 'error');
        });
      },
      editCuenta(cuenta) {
        this.form = { ...cuenta };
        this.editing = true;
        this.openModal();
      },
      deleteCuenta(id) {
  this.$swal.fire({
    title: '¿Estás seguro?',
    text: "¡Esta acción no se puede deshacer!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(`/api/cuentas/${id}`)
        .then(() => {
          this.$swal.fire('¡Éxito!', 'Cuenta eliminada correctamente.', 'success');
          this.fetchCuentas();
        })
        .catch((error) => {
          // Mostrar mensaje de error del backend
          this.$swal.fire('Error', error.response.data.message, 'error');
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
        this.form = { nombre: '', direccion: '', sucursal_id: '', tipo_venta_id: '', estado: 'activo' };
        this.editing = false;
      },
      cancelEdit() {
        this.resetForm();
        this.closeModal();
      },
      goToCuentaDetalle(id) {
    // Redirige a la ruta de detalle de la cuenta
    this.$router.push({ name: 'CuentaDetalle', params: { id: id } });
  
    
  },
    },
    mounted() {
      this.fetchCuentas();
      this.fetchSucursales();
      this.fetchTipoVentas();
    },
  };
  </script>
  
  <style scoped>
  /* Estilos personalizados */
  </style>
  