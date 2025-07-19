<script setup>
import {useBookStore} from "@/stores/book.js";
import {onMounted} from "vue";
import {useToast} from 'primevue/usetoast';

const toast = useToast();

const bookStore = useBookStore(); //AJUSTAR PARA QUANDO NÃO HAVER NENHUM LIVRO

const getBooks = async () => {
  const books = await bookStore.getBooks();

  if (books === false) {
    toast.add({severity: 'error', detail: 'Falha ao recuperar livros! Contate o suporte...', life: 3000});
  }
}

onMounted(() => {
  getBooks();
})
</script>

<template>
  <Toast/>
  <div class="card">
    <DataTable :value="bookStore.state.books" tableStyle="min-width: 50rem">
      <template #empty> Nenhum livro encontrado. </template>
      <Column field="title" header="Título"></Column>
      <Column field="isbn" header="ISBN"></Column>
      <Column field="author.name" header="Autor"></Column>
      <Column field="gender.name" header="Gênero"></Column>
    </DataTable>
  </div>
</template>

<style scoped>

</style>
