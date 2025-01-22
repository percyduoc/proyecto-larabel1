<template>
    <div class="flex grid-cols-6" >
        
        <adminlte></adminlte>
        <router-view></router-view>
    </div>
</template>

<script>
import Adminlte from './components/adminlte.vue';

export default {
    name: 'App',
    components: {
        Adminlte
    }
};
</script>
