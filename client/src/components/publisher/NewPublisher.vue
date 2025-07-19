<script setup>
import {usePublisherStore} from "@/stores/publisher.js";
import {useToast} from "primevue/usetoast";
import {useRouter} from "vue-router";

const publisherStore = usePublisherStore();
const toast = useToast();
const router = useRouter();

const newPublisher = async () => {
  const newPublisher = await publisherStore.newPublisher();

  if (!newPublisher.error) {
    toast.add({severity: 'success', detail: newPublisher.message, life: 3000});

    setTimeout(async () => {
      await router.push({name: 'editoras'});
    }, 2000)
    return;
  }

  if (newPublisher.messages) {
    for (const inputErrors in newPublisher.messages) {
      for (const inputError of newPublisher.messages[inputErrors]) {
        toast.add({severity: 'error', detail: inputError, life: 3000});
      }
    }
    return;
  }
  toast.add({severity: 'error', detail: newPublisher.message, life: 3000});
}

</script>

<template>
    <section class="w-6 formulario">
      <Toast/>
        <form v-on:submit.prevent="newPublisher()">
            <div class="flex flex-column gap-2 mb-5">
                <label for="name">Nome</label>
                <InputText id="name" v-model="publisherStore.state.form.name" aria-describedby="name-help" />
            </div>

            <div class="flex flex-column gap-2 mb-5">
                <label for="country">País de origem</label>
                <InputText id="country" v-model="publisherStore.state.form.countryOrigin" aria-describedby="country-help" />
            </div>

            <Button type="submit" class="w-2" label="Adicionar" icon="pi pi-check" />
        </form>
    </section>
</template>

<style scoped>

</style>
