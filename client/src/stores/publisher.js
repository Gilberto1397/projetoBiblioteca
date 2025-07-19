import {defineStore} from 'pinia';
import {ref} from "vue";
import axiosProvider from "@/providers/AxiosProvider.js";
import {useAuthenticationStore} from "@/stores/authentication.js";

export const usePublisherStore = defineStore('publisher', () => {
    const authenticationStore = useAuthenticationStore();

    const state = ref({
        publishers: [],
        form: {
            name: null,
            countryOrigin: null
        }
    })

    const getPublishers = async () => {
        try {
            state.value.publishers = (await axiosProvider.get('api/v1/editoras?allPublishers=1')).data.data.publishers;
            return true;
        } catch (error) {
            return false;
        }
    }

    const newPublisher = async () => {
        try {
            authenticationStore.getCsrfToken(); //todo fazer request para token em todos os post direto no provider
            const newPublisher = (await axiosProvider.post('api/v1/nova-editora', state.value.form)).data;
            clearForm();
            return newPublisher;
        } catch (error) {
            return error.response.data;
        }
    }

    const clearForm = () => {
        state.value.form.name = null;
        state.value.form.countryOrigin = null;
    }

    return {state, getPublishers, newPublisher};
})