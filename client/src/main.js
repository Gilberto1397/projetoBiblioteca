import './assets/main.css';

import {createApp} from 'vue';
import {createPinia} from 'pinia';

import App from './App.vue';
import router from './router';

//import errorHandler from "@/providers/errorHandler.js";

//primeVue
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css'; // Tema
import 'primevue/resources/primevue.min.css'; // Estilos base
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.css';
import ToastService from 'primevue/toastservice';

const app = createApp(App);

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Menubar from 'primevue/menubar';
import Toast from 'primevue/toast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';
import Calendar from 'primevue/calendar';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Password from 'primevue/password';

app.component('Button', Button);
app.component('InputText', InputText);
app.component('Menubar', Menubar);
app.component('Toast', Toast);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup);
app.component('Row', Row);
app.component('Calendar', Calendar);
app.component('InputNumber', InputNumber);
app.component('Dropdown', Dropdown);
app.component('Password', Password);

app.use(PrimeVue, {
    ripple: true,  // Efeito de clique visual
});
app.use(ToastService);

app.use(createPinia())
app.use(router)

// app.config.errorHandler = (err, vm, info) => {
//     alert('Opa, deu breti. Abre chamado!');
// };

app.mount('#app')
