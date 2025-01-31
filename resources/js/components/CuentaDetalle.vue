<template>
  <div class="p-6 bg-gray-100 min-h-screen w-full  justify-between items-center ">
    <h1 class="text-3xl font-bold mb-6 ">Detalle de la Cuenta</h1>
    <h1>Total: {{ total }}</h1>
    <button
      @click="goTodetalle"
      class="bg-blue-600 text-white px-4 py-2 my-2 rounded-md hover:bg-blue-700 shadow-md">
      Crear Nuevo Detalle
    </button>
    <div v-if="cuenta" class="bg-white p-6 shadow-lg rounded-lg">
      <h2 class="text-xl font-semibold mb-4">{{ cuenta.nombre }}</h2>
      <p><strong>Dirección:</strong> {{ cuenta.direccion }}</p>
      <p><strong>Sucursal:</strong> {{ cuenta.sucursal ? cuenta.sucursal.nombre : '' }}</p>
      <p><strong>Tipo de Venta:</strong> {{ cuenta.tipo_venta ? cuenta.tipo_venta.nombre : '' }}</p>
      <p><strong>Estado:</strong> {{ cuenta.estado ? 'Activo' : 'Inactivo' }}</p>
    </div>
    <div v-if="detalles.length > 0" class="mt-6 ">
      <h3 class="text-2xl font-semibold mb-4">Detalles Asociados</h3>
      <!-- Agrupar prestaciones por categoría -->
      <div v-for="(prestacionesPorCategoria, tipo) in agrupadoPorCategoria" :key="tipo">
  <h3 class="text-2xl font-semibold">{{ tipo }}</h3>
  <div class="overflow-x-auto"> 
  <table class="min-w-full table-auto bg-white shadow-lg rounded-lg hover:bg-slate-600 "  >
    <thead>
      <tr class="bg-gray-200">
        <th class="px-4 py-2">Prestacion</th>
        <th class="px-4 py-2">Cantidad</th>
        <th class="px-4 py-2">Valor</th>
        <th class="px-4 py-2">Estado</th>
        <th class="px-4 py-2">Acciones</th>
        <th class="px-4 py-2">Subtotal </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="detalle  in prestacionesPorCategoria" :key="detalle.id" class="hover:bg-slate-200">
        <td class="px-4 py-2 ">{{ detalle.prestacion.nombre}}</td>
        <td class="px-4 py-2">{{ detalle.cantidad_producto }}</td>
        <td class="px-4 py-2">{{ detalle.valor_producto }}</td>
        <td class="px-4 py-2">{{ detalle.estado ? 'Activo' : 'Inactivo' }}</td>
        <td class="px-4 py-2">
          <button @click="deleteDetalle(detalle.id)" class="text-red-600 px-2 py-1">
            <font-awesome-icon :icon="['fas', 'trash']" />
          </button>
        </td>
        <td class="px-4 py-2">{{ detalle.cantidad_producto * detalle.valor_producto }}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td class="px-4 py-2" colspan="5">SubTotal</td>
        <td class="px-4 py-2">{{ prestacionesPorCategoria.reduce((sum, detalle) => sum + (detalle.cantidad_producto * detalle.valor_producto), 0) }}</td>
      </tr>
    </tfoot>
  </table>
</div>
    </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['id'], 
  data() {
    return {
      cuenta: null,
      detalles: [], 
      prestaciones: [],
    
   
    };
  },
  computed: {

    total() {
      return this.detalles.reduce((sum, detalle) => {
        return sum + (detalle.cantidad_producto * detalle.valor_producto);
      }, 0);
    },


    agrupadoPorCategoria() {
    const categorias = {};

    this.detalles.forEach(prestaciones => {
      
   

      const tipo = prestaciones.tipo_prestacion  ? prestaciones.tipo_prestacion.nombre: 'Sin categoría';
 


      if (!categorias[tipo]) {  
        categorias[tipo] = [];
      }

      
      categorias[tipo].push(prestaciones);
    });

    return categorias;
  },
  },
  methods: {
    fetchCuenta() {
      axios
        .get(`/api/cuentas/${this.id}`)
        .then((response) => {
          this.cuenta = response.data;
          this.fetchDetalles(); 
        })
        .catch((error) => {
          console.error('Error al obtener la cuenta:', error);
        });
    },
    fetchDetalles() {
      axios
        .get(`/api/detalles?id_cuenta=${this.id}`) 
        .then((response) => {
          this.detalles = response.data;
        })
        .catch((error) => {
          console.error('Error al obtener los detalles:', error);
        });
    },
    fetchPrestaciones() {
      axios
        .get("/api/prestaciones")
        .then((response) => {
          this.prestaciones = response.data;
        })
        .catch((error) => {
          console.error("Error al cargar las prestaciones:", error);
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
            this.$swal.fire('¡Éxito!', 'El detalle ha sido eliminado.', 'success');
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
    this.fetchPrestaciones();
  },
};
</script>
