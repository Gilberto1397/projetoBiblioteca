<script setup>
import {usePublisherStore} from "@/stores/publisher.js";
import {onMounted} from "vue";
import {useToast} from "primevue/usetoast";

const publisherStore = usePublisherStore();
const toast = useToast();

const getPublishers = async () => {
  const publishers = await publisherStore.getPublishers();

  if (!publishers) {
    toast.add({severity: 'error', detail: 'Falha ao recuperar editoras! Contate o suporte...', life: 3000});
  }
}

onMounted(() => {
  getPublishers();
})
</script>

<template>
  <Toast/>
  <div class="card">
    <DataTable :value="publisherStore.state.publishers" tableStyle="min-width: 50rem">
      <template #empty> Nenhuma editora encontrada! </template>
      <Column field="name" header="Nome"></Column>
      <Column field="countryOrigin" header="País de origem"></Column>
    </DataTable>
  </div>
</template>

<style scoped>

</style>
