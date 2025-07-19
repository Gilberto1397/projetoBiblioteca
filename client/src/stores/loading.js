import {defineStore} from 'pinia';
import {ref} from "vue";

export const useLoadingStore = defineStore('loading', () => {
    const state = ref({
        isLoading: false,
    })

    return {state};
})