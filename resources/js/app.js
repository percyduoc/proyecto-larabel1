import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
import Swal from 'sweetalert2';

// Agregar íconos de FontAwesome
library.add(fas);

const app = createApp(App);

// Registrar FontAwesome como componente global
app.component('font-awesome-icon', FontAwesomeIcon);

// Agregar SweetAlert2 como propiedad global
app.config.globalProperties.$swal = Swal;

// Usar el router y montar la app
app.use(router).mount('#app');
