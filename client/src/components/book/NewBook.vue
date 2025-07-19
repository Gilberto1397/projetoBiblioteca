<script setup>
import {useBookStore} from "@/stores/book.js";
import {useAuthorStore} from "@/stores/author.js";
import {usePublisherStore} from "@/stores/publisher.js";
import {onMounted} from "vue";
import {useToast} from 'primevue/usetoast';
import {useRouter} from "vue-router";

const bookStore = useBookStore();
const authorStore = useAuthorStore();
const publisherStore = usePublisherStore();

const toast = useToast();
const router = useRouter();

const getValorCampos = async () => {
  if (!await authorStore.getAuthors()) {
    toast.add({severity: 'error', detail: 'Falha ao recuperar autores! Contate o suporte.', life: 3000});
  }

  if (!await publisherStore.getPublishers()) {
    toast.add({severity: 'error', detail: 'Falha ao recuperar editoras! Contate o suporte.', life: 3000});
  }
}

const newBook = async () => {
  const bookCreated = await bookStore.newBook();

  if (!bookCreated.error) {
    toast.add({severity: 'success', detail: bookCreated.message, life: 3000});

    setTimeout(async () => {
      await router.push({name: 'livros'});
    }, 2000)
     return;
  }

  if (bookCreated.messages) {
    for (const inputErrors in bookCreated.messages) {
      for (const inputError of bookCreated.messages[inputErrors]) {
        toast.add({severity: 'error', detail: inputError, life: 3000});
      }
    }
    return;
  }
  toast.add({severity: 'error', detail: bookCreated.message, life: 3000});
}

onMounted(async () => {
  await getValorCampos();
})
</script>

<template>
  <section class="w-6 formulario">
    <Toast/>

    <form v-on:submit.prevent="newBook()">
      <div class="flex flex-column gap-2 mb-5">
        <label for="title">Título</label>
        <InputText id="title" v-model="bookStore.state.form.title" aria-describedby="title-help"/>
      </div>

      <div class="flex flex-column gap-2 mb-5">
        <label for="isbn">ISBN</label>
        <InputText id="isbn" v-model="bookStore.state.form.isbn" aria-describedby="isbn-help"/>
      </div>

      <div class="flex justify-content-start align-items-center gapColunas">
        <div class="flex flex-column gap-2 mb-5">
          <label for="date">Data de publicação</label>
          <Calendar date-format="dd/mm/yy" v-model="bookStore.state.form.publicationDate" showIcon :showOnFocus="false"/>
        </div>

        <div class="flex flex-column gap-2 mb-5 align-items-center">
          <label for="stock">Em estoque</label>

          <InputNumber v-model="bookStore.state.form.inStock" showButtons buttonLayout="vertical" style="width: 3rem"
                       :min="0" :max="99">
            <template #incrementbuttonicon>
              <span class="pi pi-plus"/>
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus"/>
            </template>
          </InputNumber>
        </div>
      </div>

      <div class="flex gapColunas">
        <div class="flex flex-column gap-2 mb-5">
          <label for="author">Autor</label>
          <Dropdown v-model="bookStore.state.form.author" :options="authorStore.state.authors" optionValue="id" optionLabel="name" placeholder="Escolha um autor" checkmark :highlightOnSelect="false" class="w-full md:w-14rem" />
        </div>

        <div class="flex flex-column gap-2 mb-5">
          <label for="publishers">Editora</label>
          <Dropdown v-model="bookStore.state.form.publishersList" :options="publisherStore.state.publishers" optionValue="id" optionLabel="name" placeholder="Escolha uma editora" checkmark :highlightOnSelect="false" class="w-full md:w-14rem" />
        </div>
      </div>

      <Button type="submit" class="w-2" label="Salvar" icon="pi pi-check"/>
    </form>
  </section>
</template>

<style scoped>
.gapColunas {
  gap: 0 15%
}
</style>
