import { createRouter, createWebHistory } from 'vue-router';
import List from '../components/List.vue';
import Create from '../components/Create.vue';
import Edit from '../components/Edit.vue';
import Sucursal from '../components/Sucursal.vue';
import sucursalEdit from '../components/sucursal-edit.vue';
import Prestaciones from '../components/Prestaciones.vue';
import Precios from '../components/Precios.vue';
import TipoVentas from '../components/TipoVentas.vue';
import welcome from '../components/welcome.vue';
import TipoPrestaciones from '../components/TipoPrestaciones.vue';
import Cuentas from '../components/Cuentas.vue';
import Detallecuentas from '../components/Detallecuentas.vue';
import CuentaDetalle from '../components/CuentaDetalle.vue';
import CrearDetalle from '../components/CrearDetalle.vue';

const routes = [
    { path: '/producto', name: 'List', component: List },
    { path: '/create', name: 'Create', component: Create },
    { path: '/edit/:id', name: 'Edit', component: Edit },
    {path: '/producto/edit/:id',name: 'editProducto',component: Edit,},
    {path: '/sucursal',name: 'sucursales',component: Sucursal,},
    {path: '/sucursal/edit/:id',name: 'sucursal-edit',component: sucursalEdit,},
    {path: '/prestacion',name: 'prestaciones',component: Prestaciones,},
    {path: '/precio',name: 'precios',component: Precios,},
    {path: '/tipo-ventas',name: 'tipoventa',component: TipoVentas,},
    {path: '/',name: 'welcome',component: welcome,},
    {path:'/tipoprestacion',name:'tipoprestaciones',component:TipoPrestaciones,},
    {path:'/cuentas',name:'cuentas',component:Cuentas,},
    {path:'/detalle',name:'detalle',component:Detallecuentas,},
    {path:'/detalle/:id',name:'Cuentadetalle',component:Detallecuentas,props:true,},
    {path: '/cuentas/:id',name: 'CuentaDetalle',component: CuentaDetalle,props: true, },
    {path: '/cuentas/:id/detalles/crear', name: 'CrearDetalle',component: CrearDetalle,props: true,  },
    
];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
