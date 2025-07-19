<script setup>
import {useAuthenticationStore} from "@/stores/authentication.js";
import {useToast} from 'primevue/usetoast';
import {useRoute, useRouter} from "vue-router";
import {onMounted} from "vue";

const toast = useToast();
const authenticationStore = useAuthenticationStore();
const routeParams = useRoute();
const router = useRouter();

const login = async () => {
  const logado = await authenticationStore.login();
  authenticationStore.loadingStore.state.isLoading = false;

  if (!logado.error) {
    toast.add({severity: 'success', detail: logado.message, life: 3000});

    setTimeout(async () => {
      await router.push({name: 'livros'});
    }, 1000)
    return;
  }

  if (logado.messages) {
    for (const inputErrors in logado.messages) {
      for (const inputError of logado.messages[inputErrors]) {
        toast.add({severity: 'error', detail: inputError, life: 3000});
      }
    }
    return;
  }
  toast.add({severity: 'error', detail: logado.message, life: 3000});
}

onMounted(() => {
  if (routeParams.query.needAuth) {
    toast.add({
      severity: 'info',
      detail: 'Você precisa estar logado!.',
      life: 5000
    });
  }
})
</script>

<template>
  <section class="w-6 formulario">
    <Toast/>
    <form v-on:submit.prevent="login()">
      <div class="flex flex-column gap-2 mb-5">
        <label for="email">Email</label>
        <InputText id="email" v-model="authenticationStore.state.form.email" aria-describedby="email-help"/>
      </div>

      <div class="flex flex-column gap-2 mb-5">
        <label for="password">Senha</label>
        <Password id="password" :feedback="false" toggleMask v-model="authenticationStore.state.form.password"/>
      </div>

      <Button type="submit" class="w-2" label="Logar" icon="pi pi-check"/>
    </form>
  </section>
</template>

<style scoped>
:deep(.p-password-input) {
  width: 100%;
}
</style>
