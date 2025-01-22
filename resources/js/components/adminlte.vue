<template>
  <!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="/" class="brand-link">
      <!--begin::Brand Image-->
    
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">Medicas</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column "
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
        <li class="nav-header">Menu</li>
        <li class="nav">
          <a href="/" class="nav-link">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>Inicio</p>
          </a>
        </li>
        <li class="nav">
          <a @click="gotosucursal" class="nav-link">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>
              Sucursales
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
     
        </li>
        <li class="nav">
          <a @click="goToCreate" class="nav-link active">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>Productos</p>
          </a>
        </li>

        <li class="nav">
          <a @click="goToPrecio" class="nav-link active">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>
              Precio
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav ">
            <li class="nav-item">
              <a @click="goToPrestacion" class="nav-link active">
                <i class="nav-icon bi bi-circle"></i>
                <p>Prestaciones</p>
              </a>
            </li>
            <li class="nav-item">
              <a @click="goTotipoprestacio" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Tipo Prestacion</p>
              </a>
            </li>
            <li class="nav-item">
              <a @click="goTotipoventa" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Tipo Venta</p>
              </a>
            </li>
            <li class="nav-item">
              <a @click="goTocuentas" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Cuenta</p>
              </a>
            </li>
            <li class="nav-item">
              <a @click="goTodetalle" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Detalle</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->

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
        
       },
       goToPrecio(){
            this.$router.push({ name: 'precios' });
       },
       goTotipoprestacio(){
        this.$router.push({ name: 'tipoprestaciones' });
       },
       gotosucursal(){
            this.$router.push({ name: 'sucursales' });
       },
       editItem(id) {
           this.$router.push({ name: 'Edit', params: { id } });
           
       },
       goToCreate() {  
             // Redirige a la ruta de creación
          this.$router.push({ name: 'List' });
      },
       deleteItem() {
   
       },
       home(){
            this.$router.push({ name: 'home' });
       },
       goToPrestacion(){
            this.$router.push({ name: 'prestaciones' });
       },
       goTotipoventa(){
            this.$router.push({ name: 'tipoventa' });
       },
       goTocuentas(){
            this.$router.push({ name: 'cuentas' });
       },
       goTodetalle(){
            this.$router.push({ name: 'detalle' });
       },

   },
   mounted() {
       this.fetchData();
   },
};
</script>