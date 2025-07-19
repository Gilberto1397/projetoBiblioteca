<script setup>
import {useAuthorStore} from "@/stores/author.js";
import {useRouter} from "vue-router";
import {useToast} from 'primevue/usetoast';

const authorStore = useAuthorStore();
const router = useRouter();
const toast = useToast();

const newAuthor = async () => {
  const newAuthor = await authorStore.newAuthor();

  if (!newAuthor.error) {
    toast.add({severity: 'success', detail: newAuthor.message, life: 3000});

    setTimeout(async () => {
      await router.push({name: 'autores'});
    }, 2000)
    return;
  }

  if (newAuthor.messages) {
    for (const inputErrors in newAuthor.messages) {
      for (const inputError of newAuthor.messages[inputErrors]) {
        toast.add({severity: 'error', detail: inputError, life: 3000});
      }
    }
    return;
  }
  toast.add({severity: 'error', detail: newAuthor.message, life: 3000});
}
</script>

<template>
  <section class="w-6 formulario">
    <Toast/>
    <form v-on:submit.prevent="newAuthor()">
      <div class="flex flex-column gap-2 mb-5">
        <label for="name">Nome</label>
        <InputText id="name" v-model="authorStore.state.form.name" aria-describedby="name-help"/>
      </div>

      <div class="flex flex-column gap-2 mb-5">
        <label for="nationality">Nacionalidade</label>
        <InputText id="nationality" v-model="authorStore.state.form.nationality" aria-describedby="nationality-help"/>
      </div>

      <div class="flex flex-column gap-2 mb-5">
        <label for="date">Data de Aniversário</label>
        <Calendar date-format="dd/mm/yy" v-model="authorStore.state.form.dateBirth" showIcon :showOnFocus="false"/>
      </div>

      <Button type="submit" class="w-2" label="Salvar" icon="pi pi-check"/>
    </form>
  </section>
</template>

<style scoped>

</style>
