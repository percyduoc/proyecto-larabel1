<template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <h1 class="text-4xl font-bold mb-6">Agregar Nuevo Detalle</h1>
      <form @submit.prevent="crearDetalle" class="bg-white p-6 shadow-lg rounded-lg">
        
        <!-- Selección de Prestación -->
        <div class="mb-4">
        <label for="id_prestaciones" class="block text-gray-700 font-semibold">Prestación:</label>
        <select
          id="id_prestaciones"
          v-model="detalle.id_prestaciones"
          required
          class="w-full px-4 py-2 border rounded-lg"
        >
          <option v-for="prestacion in prestaciones" :key="prestacion.codigo" :value="prestacion.codigo">
            {{ prestacion.nombre }}
          </option>
        </select>
      </div>
      
        <!-- Campo de Cantidad -->
        <div class="mb-4">
          <label for="cantidad_producto" class="block text-gray-700 font-semibold">Cantidad:</label>
          <input
            id="cantidad_producto"
            v-model="detalle.cantidad_producto"
            type="number"
            min="1"
            required
            class="w-full px-4 py-2 border rounded-lg"
            placeholder="Ingrese la cantidad"
          />
        </div>
  
        <!-- Campo de Valor -->
        <div class="mb-4">
          <label for="valor_producto" class="block text-gray-700 font-semibold">Valor:</label>
          <input
            id="valor_producto"
            v-model="detalle.valor_producto"
            type="number"
            min="1"
            required
            class="w-full px-4 py-2 border rounded-lg"
            placeholder="Ingrese el valor"
          />
        </div>
  
        <!-- Selección de Estado -->
        <div class="mb-4">
          <label for="estado" class="block text-gray-700 font-semibold">Estado:</label>
          <select
            id="estado"
            v-model="detalle.estado"
            required
            class="w-full px-4 py-2 border rounded-lg"
          >
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
          </select>
        </div>
  
        <!-- Botón de Guardar -->
        <button
          @click="saveDetalle"
          class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
        >
          Guardar Detalle
        </button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from "axios";

  export default {
    props: ["id"], // Recibe el ID de la cuenta desde la ruta
    data() {
      return {
        detalle: {
          id_cuenta: this.id,
          id_prestaciones: "",
          cantidad_producto: 0,
          valor_producto: 0,
          estado: 1, // Por defecto Activo
        },
        cuentas: [], // Lista de cuentas
        prestaciones: [], // Lista de productos
      };
    },
    methods: {
      // Método para crear un detalle
      saveDetalle() {
  const action = this.editing
    ? axios.put(`/api/detalles/${this.form.id}`, this.detalle)
    : axios.post('/api/detalles', this.detalle);

  action.then(() => {
    this.$swal.fire('¡Éxito!', this.editing ? 'Actualizado correctamente.' : 'Creado correctamente.', 'success');
    this.$router.push({ name: 'CuentaDetalle' });
  }).catch((error) => {
    console.error('Error al guardar el detalle:', error);
    this.$swal.fire('Error', 'Hubo un problema al guardar el detalle.', 'error');
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
      
      // Obtener la lista de cuentas
      fetchCuentas() {
        axios
          .get("/api/cuentas")
          .then((response) => {
            this.cuentas = response.data;
          })
          .catch((error) => {
            console.error("Error al cargar las cuentas:", error);
          });
      },
      // Obtener la lista de productos
    },
    mounted() {
      this.fetchCuentas();
      this.fetchPrestaciones();

    },
  };
  </script>
  