import { createRouter, createWebHistory } from 'vue-router'
import CadastroPage from "../views/CadastroPage.vue";
import FuncionarioPage from "../views/FuncionarioPage.vue";
import InstituicaoPage from '../views/InstituicaoPage.vue'
import AboutView from '../views/AboutView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/cadastro'
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView,
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
