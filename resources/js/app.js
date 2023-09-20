import './bootstrap';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';

import  { createApp} from "vue"
import App from "../src/App.vue"

import router from './router';

createApp(App).use(router).mount('#app');
