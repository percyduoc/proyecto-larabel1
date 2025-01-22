<template>
  <div class="p-6 bg-gray-50 min-h-screen w-full">
    <h1 class="text-4xl font-bold mb-6 text-center text-blue-700">Gestión de Cuentas</h1>

    <!-- Lista de cuentas -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Lista de Cuentas</h2>
        <button
          @click="openModal()"
          class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-md"
        >
          Crear Nueva Cuenta
        </button>
      </div>
      <table class="w-full border-collapse bg-white rounded-md overflow-hidden">
        <thead>
          <tr class="bg-gray-200 text-gray-700">
            <th class="p-3 text-left">Nombre</th>
            <th class="p-3 text-left">Dirección</th>
            <th class="p-3 text-left">Sucursal</th>
            <th class="p-3 text-left">Tipo de Venta</th>
            <th class="p-3 text-left">Estado</th>
            <th class="p-3 text-left">Total Cuenta</th>
            <th class="p-3 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="cuenta in cuentas"
            :key="cuenta.id"
            class="odd:bg-gray-50 even:bg-white hover:bg-gray-100"
          >
            <td class="p-3 text-gray-800">{{ cuenta.nombre }}</td>
            <td class="p-3 text-gray-800">{{ cuenta.direccion }}</td>
            <td class="p-3 text-gray-800">
              {{ cuenta.sucursal ? cuenta.sucursal.nombre : '' }}
            </td>
            <td class="p-3 text-gray-800">
              {{ cuenta.tipo_venta ? cuenta.tipo_venta.nombre : '' }}
            </td>
            <td class="p-3 text-gray-800">
              {{ cuenta.estado ? 'Activo' : 'Inactivo' }}
            </td>
            <td class="p-3 text-gray-800 bg-green-200 rounded-full ">{{ cuenta.total_cuenta }}</td>
            <td class="p-3 flex justify-center gap-2">
              <button
                class="text-yellow-500 hover:text-yellow-600"
                @click="editCuenta(cuenta)"
              >
                <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              </button>
              <button
                class="text-blue-500 hover:text-blue-600"
                @click="goToCuentaDetalle(cuenta.id)"
              >
                <font-awesome-icon :icon="['fas', 'eye']" />
              </button>
              <button
                class="text-red-500 hover:text-red-600"
                @click="deleteCuenta(cuenta.id)"
              >
                <font-awesome-icon :icon="['fas', 'trash']" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal de formulario -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">
          {{ editing ? 'Editar Cuenta' : 'Crear Cuenta' }}
        </h2>
        <form @submit.prevent="saveCuenta" class="space-y-4">
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700"
              >Nombre:</label
            >
            <input
              id="nombre"
              v-model="form.nombre"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label
              for="direccion"
              class="block text-sm font-medium text-gray-700"
              >Dirección:</label
            >
            <input
              id="direccion"
              v-model="form.direccion"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label
              for="sucursal_id"
              class="block text-sm font-medium text-gray-700"
              >Sucursal:</label
            >
            <select
              id="sucursal_id"
              v-model="form.sucursal_id"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option
                v-for="sucursal in sucursales"
                :key="sucursal.id"
                :value="sucursal.id"
              >
                {{ sucursal.nombre }}
              </option>
            </select>
          </div>
          <div>
            <label
              for="tipo_venta_id"
              class="block text-sm font-medium text-gray-700"
              >Tipo de Venta:</label
            >
            <select
              id="tipo_venta_id"
              v-model="form.tipo_venta_id"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
            >
              <option
                v-for="tipoVenta in tipoVentas"
                :key="tipoVenta.id"
                :value="tipoVenta.id"
              >
                {{ tipoVenta.nombre }}
              </option>
            </select>
          </div>
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700"
              >Estado:</label
            >
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
          <div class="flex items-center justify-end gap-3">
            <button
              type="button"
              @click="closeModal"
              class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
            >
              Cerrar
            </button>
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
            >
              {{ editing ? 'Actualizar' : 'Guardar' }}
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
          estado: 'activo', 
        },
        editing: false,
        showModal: false,
      };
    },
    methods: {
      fetchCuentas() {
    axios
      .get('/api/cuentas')
      .then((response) => {
        this.cuentas = response.data.map((cuenta) => ({
          ...cuenta,
          total_cuenta: cuenta.total_cuenta || 0, 
        }));
      })
      .catch((error) => {
        console.error('Error al obtener cuentas:', error);
      });
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
  