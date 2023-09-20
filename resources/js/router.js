// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import Ahorros from '../src/componentes/Ahorros.vue';


const routes = [
  {
    path: '/ahorros',
    name: 'Ahorros',
    component: Ahorros,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
