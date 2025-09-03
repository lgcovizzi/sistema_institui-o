import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

// Criar um serviço de toast simples
const toast = {
  install: (app: any) => {
    // Adicionar um método global $toast ao app
    app.config.globalProperties.$toast = {
      // Métodos para diferentes tipos de toast
      success(message: string) {
        alert(`Sucesso: ${message}`);
      },
      error(message: string) {
        alert(`Erro: ${message}`);
      },
      info(message: string) {
        alert(`Info: ${message}`);
      },
      warning(message: string) {
        alert(`Aviso: ${message}`);
      }
    };

    // Adicionar um método para componentes usarem via composable
    app.provide('toast', app.config.globalProperties.$toast);
  }
};

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(toast) // Usar o serviço de toast simples

app.mount('#app')
