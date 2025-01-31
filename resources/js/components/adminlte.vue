<template >
  <div class="flex">
    <!-- Sidebar -->
    <aside
      :class="['app-sidebar bg-gray-800 text-white shadow h-screen transition-all duration-300', isCollapsed ? '-ml-64' : 'ml-0']"
    >
      <!-- Sidebar Header -->
      <div class="flex items-center justify-between px-4 py-3">
        <a href="/" class="text-xl font-bold">Medicas</a>
        <button @click="toggleSidebar" class="text-white focus:outline-none">
          <font-awesome-icon :icon="['fas', isCollapsed ? 'bars' : 'times']" />
        </button>
      </div>

      <!-- Sidebar Menu -->
      <div class="sidebar-wrapper px-2">
        <nav>
          <ul>
          
            <li v-for="item in menuItems" :key="item.name" class="mb-2">
              <a
                @click="navigate(item.route)"
                class="flex items-center px-2 py-2 rounded-md hover:bg-gray-700 cursor-pointer"
              >
                <font-awesome-icon :icon="['fas', item.icon]" class="mr-2" />
                <span class="text-white">{{ item.name }}</span>
                <font-awesome-icon
                  v-if="item.children"
                  :icon="['fas', 'chevron-down']"
                  class="ml-auto"
                  @click.stop="toggleSubmenu(item)"
                />
              </a>
              <ul v-if="item.children && item.isOpen" class="pl-2">
                <li v-for="subItem in item.children" :key="subItem.name" class="mt-1">
                  <a
                    @click="navigate(subItem.route)"
                    class="flex items-center px-1 py-2 rounded-md  hover:bg-gray-600 cursor-pointer"
                  >
                    <font-awesome-icon :icon="['fas', subItem.icon]" class="mr-2" />
                    <span class="text-white">{{ subItem.name }}</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Botón para abrir Sidebar -->
    <button
      v-if="isCollapsed"
      @click="toggleSidebar"
      class="fixed top-4 left-4 bg-gray-800 text-white p-2 rounded-md shadow-lg"
    >
      <font-awesome-icon :icon="['fas', 'bars']" />
    </button>

 

  </div>
</template>

<script>
export default {
  data() {
    return {
      isCollapsed: false,
      menuItems: [
        { name: "Inicio", route: "welcome", icon: "home" },
        { name: "Sucursales", route: "sucursales", icon: "building" },
        { name: "Cuenta", route: "cuentas",icon:"user",isOpen: false,
          children: [
            { name: "Prestaciones", route: "prestaciones" ,icon:"hand-holding-medical"},
            { name: "Categorias", route: "tipoprestaciones",icon:"book-medical" },
            { name: "Ventas", route: "tipoventa" ,icon:"notes-medical"},
            {name: "Precio",route: "precios",icon:"dollar-sign"},
          ],
        },
   
      ],
    };
  },
  methods: {
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
    },
    toggleSubmenu(item) {
      item.isOpen = !item.isOpen;
    },
    navigate(route) {
      this.$router.push({ name: route });
      this.isCollapsed = true; 
    },
  },
};
</script>

<style scoped>
.app-sidebar {
  width: 250px;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
}
a{
  text-decoration: none;
  color: white;
}
</style>
