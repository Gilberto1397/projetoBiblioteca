<script setup>
import {ref} from "vue";

const generos = ref({
    genero1: null,
    genero2: null,
    genero3: null,
})
</script>

<template>
    <section class="w-6 formulario">
        <h1 class="text-center mb-8">Criar Gênero</h1>
        <form>
            <div class="flex flex-column gap-2 mb-5">
                <label for="genero1">Primeiro Gênero</label>
                <InputText v-model="generos.genero1" id="genero1" aria-describedby="genero1-help" />
            </div>

            <div class="flex flex-column gap-2 mb-5">
                <label for="genero2">Segundo Gênero</label>
                <InputText v-model="generos.genero2" id="genero2" aria-describedby="genero2-help" />
            </div>

            <div class="flex flex-column gap-2 mb-5">
                <label for="genero3">Terceiro Gênero</label>
                <InputText v-model="generos.genero3" id="genero3" aria-describedby="genero3-help" />
            </div>

            <Button type="submit" class="w-2" label="Criar" icon="pi pi-check" />
        </form>
    </section>
</template>

<style scoped>
</style>
