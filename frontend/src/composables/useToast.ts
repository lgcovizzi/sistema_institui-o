import { ref } from 'vue'

interface Toast {
  id: number
  type: 'success' | 'error' | 'warning' | 'info'
  message: string
  duration: number
}

// Estado global dos toasts
const toasts = ref<Toast[]>([])

// Funções globais para gerenciar toasts
const addToast = (type: Toast['type'], message: string, duration = 8000) => {
  const id = Date.now() + Math.random()
  const toast: Toast = {
    id,
    type,
    message,
    duration
  }
  
  toasts.value.push(toast)
  
  if (duration > 0) {
    setTimeout(() => {
      removeToast(id)
    }, duration)
  }
  
  return id
}

const removeToast = (id: number) => {
  const index = toasts.value.findIndex(toast => toast.id === id)
  if (index > -1) {
    toasts.value.splice(index, 1)
  }
}

const success = (message: string, duration?: number) => {
  return addToast('success', message, duration)
}

const error = (message: string, duration?: number) => {
  return addToast('error', message, duration)
}

const warning = (message: string, duration?: number) => {
  return addToast('warning', message, duration)
}

const info = (message: string, duration?: number) => {
  return addToast('info', message, duration)
}

const clear = () => {
  toasts.value = []
}

// Composable para usar nos componentes
export function useToast() {
  return {
    toasts,
    addToast,
    removeToast,
    success,
    error,
    warning,
    info,
    clear
  }
}

// Instância global para ser usada em toda a aplicação
export const toast = {
  success,
  error,
  warning,
  info,
  clear
}