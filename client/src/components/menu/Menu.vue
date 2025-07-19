<template>
    <div class="card mb-8">
        <Menubar class="bg-green-500 border-noround border-none" :model="routes">
            <template #item="{ item, props, hasSubmenu }">
                <router-link v-on:click="authenticationStore.logout(item.name)" v-if="item.meta.public === publicRoutes" class="menuItem" :to="item.path">
                    <span :class="item.meta.icon" />
                    <span class="ml-2">{{ item.meta.label }}</span>
                </router-link>
            </template>
        </Menubar>
    </div>
</template>

<script setup>
import {computed} from "vue";
import {useAuthenticationStore} from "@/stores/authentication.js";

const authenticationStore = useAuthenticationStore();

const props = defineProps({
    routes: {
        type: Array,
        required: true
    }
})

const publicRoutes = computed(() => {
  return !Boolean(authenticationStore.state.loggedIn);
})
</script>

<style scoped>
.menuItem {
    text-decoration:  none;
    color: white;
    display: flex;
    gap: 0 10px;
    padding: 15px;
}

.menuItem:hover {
    color: black;
}

:deep(.p-menuitem-content) {
    transition: 0.3s
}

:deep(.p-menuitem-content:hover) {
    background-color: #a4f4a9;
    border-radius: 15px;
}

:deep(.p-menubar-root-list) {
    background-color: #4caf50;
    width: 100%;
}

@media only screen and (max-width: 960px) {
    .menuItem {
        color: black;
    }
}
</style>
