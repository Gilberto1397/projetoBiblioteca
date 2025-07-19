import {defineStore} from 'pinia';
import {ref} from "vue";
import axiosProvider from "@/providers/AxiosProvider.js";
import {useRouter} from "vue-router";
import {useLoadingStore} from "@/stores/loading.js";

export const useAuthenticationStore = defineStore('authentication', () => {
    const routeChange = useRouter();
    const loadingStore = useLoadingStore();

    const state = ref({
        form: {
            email: "",
            password: "",
        },
        loggedIn: localStorage.getItem("loggedIn") ?? false, //CASO O COOKIE DE SESSÃO SEJA EXCLUÍDO, O USUÁRIO NÃO ESTARÁ LOGADO MESMO COM O LOGGEDIN
    })

    const login = async () => {
        try {
            loadingStore.state.isLoading = true;
            await getCsrfToken();
            const response = (await axiosProvider.post('login', state.value.form)).data;

            if (!response.error) {
                state.value.loggedIn = true;
                localStorage.setItem('loggedIn', true);

                state.value.form.email = "";
                state.value.form.password = "";
            }
            return response;
        } catch (error) {
            return error.response.data;
        }
    }

    const logout = async (routeName) => {
        if (routeName === 'logout') {
            state.value.loggedIn = false;
            localStorage.removeItem('loggedIn');
            await routeChange.push({name: "login"});
        }
    }

    const getCsrfToken = async () => {
        await axiosProvider.get('obiscoitincsrf')
    }

    return {state, login, logout, getCsrfToken, loadingStore};
})
