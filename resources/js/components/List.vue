
 <template>
    <div class="p-6 bg-gray-100 min-h-screen w-full">
      <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Lista de Productos</h1>
        <div class="content">
    <button @click="goToCreate" class="w-24 bg-green-500 text-white my-2 py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Crear Nuevo</button>

   </div>
  
  <!-- Tabla de productos -->
  <table class="  table-auto mt-4 border-collapse border border-gray-200">
    <thead>
      <tr>
        <th class="px-4 py-2 border border-gray-200">Código</th>
        <th class="px-4 py-2 border border-gray-200">Nombre</th>
        <th class="px-4 py-2 border border-gray-200">Valor</th>
        <th class="px-4 py-2 border border-gray-200">Estado</th>
        <th class="px-4 py-2 border border-gray-200">Acciones</th>
      </tr>
    </thead>
    <tbody>
        <tr v-for="item in items" :key="item.id">
        <td class="px-4 py-2 border border-gray-200">{{ item.codigo }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ item.nombre }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ item.valor }}</td>
        <td class="p-3 text-left">{{ item.estado ? 'Activo' : 'Inactivo' }}</td>
        <td class="px-4 py-2 border border-gray-200">
          <button @click="editItem(item.id)" class="text-yellow-200 px-2 py-1 mr-2"><font-awesome-icon :icon="['fas', 'pen-to-square']" /></button>
          <button @click="deleteItem(item.id)" class="text-red-600 px-2 py-1"><font-awesome-icon :icon="['fas', 'trash']" /></button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Botón para agregar producto -->
  <!-- Botón para ir al formulario de creación -->
   




      </div>

    </div>
    
  </template>
 
 <script>
 import axios from 'axios';
 
 export default {
    data() {
        return {
            items: [],
        };
    },
    methods: {
        fetchData() {
            axios.get('/api/productos').then((response) => {
                this.items = response.data;
            });
        },
        editItem(id) {
            this.$router.push({ name: 'Edit', params: { id

             } });
            
        },
        goToCreate() {  
              // Redirige a la ruta de creación
           this.$router.push({ name: 'Create' });
       },
        deleteItem(id) {
          this.$swal.fire('¡Éxito!', 'se ah eliminado correctamente .', 'success');
            axios.delete(`/api/productos/${id}`).then(() => {
                this.fetchData();
            });
        },
    },
    mounted() {
        this.fetchData();
    },
 };
 </script>
 