import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import CadastroPage from '../views/CadastroPage.vue'
import FuncionarioPage from '../views/FuncionarioPage.vue'
import InstituicaoPage from '../views/InstituicaoPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/cadastro',
      name: 'cadastro',
      component: CadastroPage,
    },
    {
      path: '/funcionarios',
      name: 'funcionarios',
      component: FuncionarioPage,
    },
    {
      path: '/instituicoes',
      name: 'instituicoes',
      component: InstituicaoPage,
    },
  ],
})

export default router
