import {defineStore} from 'pinia';
import {ref} from "vue";
import axiosProvider from "@/providers/AxiosProvider.js";

export const useAuthorStore = defineStore('author', () => {
    const state = ref({
        authors: [],
        form: {
            name: null,
            nationality: null,
            dateBirth: null
        }
    })

    const getAuthors = async () => {
        try {
            state.value.authors = (await axiosProvider.get('api/v1/autores')).data.authors;
            return true;
        } catch (error) {
            return false;
        }
    }

    const newAuthor = async () => {
        try {
            state.value.form.dateBirth = state.value.form.dateBirth?.toLocaleDateString('pt-BR');
            const response = (await axiosProvider.post('api/v1/novo-autor', state.value.form)).data;

            cleanForm();
            return response;
        } catch (error) {
            return error.response.data
        }
    }

    const cleanForm = () => {
        state.value.form.name = null;
        state.value.form.nationality = null;
        state.value.form.dateBirth = null;
    }

    return {state, getAuthors, newAuthor};
})