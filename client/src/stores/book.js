import {defineStore} from 'pinia';
import {ref} from "vue";
import axiosProvider from "@/providers/AxiosProvider.js";

export const useBookStore = defineStore('book', () => {
    const state = ref({
        books: [],
        form: {
            title: null,
            isbn: null,
            publicationDate: null,
            inStock: 0,
            author: null,
            publishersList: null, //todo mandar mais de 1 ao mesmo tempo
            gender: 1,
        }
    })

    const getBooks = async () => {
        try {
            const response = (await axiosProvider.get('api/v1/livros?allBooks=1')).data;
            state.value.books = response.data.books;
        } catch (error) {
            return false;
        }
    }

    const newBook = async () => {
        try {
            state.value.form.publicationDate = state.value.form.publicationDate?.toLocaleDateString('pt-BR') ?? null;
            state.value.form.publishersList = [state.value.form.publishersList] ?? null; //todo melhorar isso aqui e a de cima
            const response = (await axiosProvider.post('api/v1/novo-livro', state.value.form)).data;

            setTimeout(() => {
                cleanForm();
            }, 1000);
            return response;
        } catch (error) {
            return error.response?.data;
        }
    }

    const cleanForm = () => {
        state.value.form.title = null;
        state.value.form.isbn = null;
        state.value.form.publicationDate = null;
        state.value.form.inStock = 0;
        state.value.form.author = null;
        state.value.form.publishersList = null; //todo mandar mais de 1 ao mesmo temp;
        state.value.form.gender = 1;
    }

    return {state, getBooks, newBook};
})
