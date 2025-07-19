<script setup>
import {useAuthorStore} from "@/stores/author.js";
import {useToast} from "primevue/usetoast";
import {onMounted} from "vue";

const authorStore = useAuthorStore();
const toast = useToast();

const getAuthors = async () => {
  const authors = await authorStore.getAuthors();

  if (!authors) {
    toast.add({ severity: 'error', detail: 'Falha ao recuperar autores', life: 3000 });
  }
}

onMounted(() => {
  getAuthors();
})

</script>

<template>
  <Toast/>
  <div class="card">
    <DataTable :value="authorStore.state.authors" tableStyle="min-width: 50rem">
      <template #empty> Nenhum autor encontrado! </template>
      <Column field="name" header="Nome"></Column>
      <Column field="nationality" header="Nacionalidade"></Column>
      <Column field="dateBirth" header="Data de Nascimento"></Column>
    </DataTable>
  </div>
</template>

<style scoped>

</style>
