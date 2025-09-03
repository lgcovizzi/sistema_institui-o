import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import InstituicoesView from '../views/InstituicoesView.vue'
import RegistrosView from '../views/RegistrosView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/instituicoes',
      name: 'instituicoes',
      component: InstituicoesView,
    },
    {
      path: '/cadastro',
      name: 'cadastro',
      component: () => import('../views/CadastroView.vue'),
    },
    {
      path: '/registros',
      name: 'registros',
      component: () => import('../views/RegistrosView.vue'),
    },
  ],
})

export default router