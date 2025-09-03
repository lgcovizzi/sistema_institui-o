import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import { toast } from '@/composables/useToast'

// Plugin para fornecer o toast globalmente
const toastPlugin = {
  install: (app: any) => {
    // Adicionar o toast como propriedade global
    app.config.globalProperties.$toast = toast
    
    // Fornecer o toast via provide/inject
    app.provide('toast', toast)
  }
}

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(toastPlugin)

app.mount('#app')
