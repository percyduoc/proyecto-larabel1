<template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <h1 class="text-3xl font-bold mb-6">Detalle de la Cuenta</h1>
      <h1>Total: {{ total }}</h1>
      <button
        @click="goTodetalle"
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
      >
        Crear Nuevo Detalle
      </button>
      <div v-if="cuenta" class="bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold mb-4">{{ cuenta.nombre }}</h2>
        <p><strong>Dirección:</strong> {{ cuenta.direccion }}</p>
        <p><strong>Sucursal:</strong> {{ cuenta.sucursal ? cuenta.sucursal.nombre : '' }}</p>
        <p><strong>Tipo de Venta:</strong> {{ cuenta.tipo_venta ? cuenta.tipo_venta.nombre : '' }}</p>
        <p><strong>Estado:</strong> {{ cuenta.estado ? 'Activo' : 'Inactivo' }}</p>

       


      </div>
  
      <div v-if="detalles.length > 0" class="mt-6">
        <h3 class="text-2xl font-semibold mb-4">Detalles Asociados</h3>
        <table class="min-w-full table-auto bg-white shadow-lg rounded-lg">
          <thead>
            <tr class="bg-gray-200">
              <th class="px-4 py-2">Producto</th>
              <th class="px-4 py-2">Cantidad</th>
              <th class="px-4 py-2">Valor</th>
              <th class="px-4 py-2">Estado</th>
              <th class="px-4 py-2">Acciones</th>
              <th class="px-4 py-2">Total</th>
              

            </tr>
          </thead>
          <tbody>
            <tr v-for="detalle in detalles" :key="detalle.id">
              <td class="px-4 py-2">{{ detalle.producto.nombre }}</td>
              <td class="px-4 py-2">{{ detalle.cantidad_producto }}</td>
              <td class="px-4 py-2">{{ detalle.valor_producto }}</td>
              <td class="px-4 py-2">{{ detalle.estado ? 'Activo' : 'Inactivo' }}</td>
              <td class="px-4 py-2">

                <button
                  class="text-red-600 px-2 py-1"
                  @click="deleteDetalle(detalle.id)"
                >
                  <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
              </td>
              <td class="px-4 py-2">{{ detalle.cantidad_producto * detalle.valor_producto }}</td>

            </tr>
          </tbody>
        </table>
      </div>
  
 
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['id'], // Recibe el ID de la cuenta desde la ruta
    data() {
      return {
        cuenta: null,
        detalles: [], // Lista de detalles asociados a la cuenta
      };
    },
    computed: {
    // Propiedad computada para calcular el total de todos los detalles
    total() {
      return this.detalles.reduce((sum, detalle) => {
        return sum + (detalle.cantidad_producto * detalle.valor_producto);
      }, 0);
    },
  },
    methods: {
      fetchCuenta() {
        axios
          .get(`/api/cuentas/${this.id}`)
          .then((response) => {
            this.cuenta = response.data;
            this.fetchDetalles(); // Obtén los detalles después de cargar la cuenta
          })
          .catch((error) => {
            console.error('Error al obtener la cuenta:', error);
          });
      },
      fetchDetalles() {
  axios
    .get(`/api/detalles?id_cuenta=${this.id}`) // Pasa el ID de la cuenta
    .then((response) => {
      this.detalles = response.data;
    })
    .catch((error) => {
      console.error('Error al obtener los detalles:', error);
    });
  },
    goTodetalle() {
      this.$router.push({ name: 'CrearDetalle', params: { id: this.cuenta.id } });
    },
    deleteDetalle(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este detalle?')) {
      axios
        .delete(`/api/detalles/${id}`)
        .then(() => {
          this.$swal.fire('¡Éxito!', this.editing ? 'Actualizado correctamente.' : 'Creado correctamente.', 'success');
          this.fetchDetalles(); // Actualiza la lista de detalles
        })
        .catch((error) => {
          console.error('Error al eliminar el detalle:', error);
          alert('No se pudo eliminar el detalle');
        });
    }
  },


    },
    mounted() {
      this.fetchCuenta();
    },
  };
  
  </script>
  