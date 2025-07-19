import { createApp } from 'vue';
import App from '../App.vue'

const app = createApp(App);

const errorHandler = app.config.errorHandler = (err, vm, info) => {
    // err: Objeto do erro capturado
    // vm: Instância do componente onde o erro ocorreu
    // info: Contexto do erro (ex: 'hook:created', 'v-on handler', etc.)

    console.log('Opa, deu breti. Abre chamado!');
};

export default errorHandler;
