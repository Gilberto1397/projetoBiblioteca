<script setup>
import {RouterView} from 'vue-router';
import router from '@/router/';
import Menu from "@/components/menu/Menu.vue";
import LoadingOverlay from '@/components/loading/Loading.vue';
import {useLoadingStore} from "@/stores/loading.js";

const loadingStore = useLoadingStore();

</script>

<template>
  <div>
    <LoadingOverlay :isLoading="loadingStore.state.isLoading" />
    <Menu :routes="router.getRoutes()"/>

    <transition name="routes">
      <router-view></router-view>
    </transition>
  </div>
</template>

<style>
.formulario {
  margin: 0 auto;
}

.routes-enter-active, .routes-leave-active {
  transition: all 0.5s;
  opacity: 0;
}
</style>
