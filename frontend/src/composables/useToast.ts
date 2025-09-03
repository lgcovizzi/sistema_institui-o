import { ref } from 'vue'

interface Toast {
  id: number
  type: 'success' | 'error' | 'warning' | 'info'
  message: string
  duration: number
  timeoutId?: number
  remainingTime?: number
  startTime?: number
  isPaused?: boolean
}

// Estado global dos toasts
const toasts = ref<Toast[]>([])
const MAX_TOASTS = 5 // Limite máximo de toasts simultâneos

// Funções globais para gerenciar toasts
const addToast = (type: Toast['type'], message: string, duration = 8000) => {
  const id = Date.now() + Math.random()
  
  // Remove toasts mais antigos se exceder o limite
  if (toasts.value.length >= MAX_TOASTS) {
    const oldestToast = toasts.value[0]
    removeToast(oldestToast.id)
  }
  
  const toast: Toast = {
    id,
    type,
    message,
    duration,
    remainingTime: duration,
    startTime: Date.now(),
    isPaused: false
  }
  
  toasts.value.push(toast)
  
  if (duration > 0) {
    const timeoutId = setTimeout(() => {
      removeToast(id)
    }, duration)
    toast.timeoutId = timeoutId
  }
  
  return id
}

const removeToast = (id: number) => {
  const index = toasts.value.findIndex(toast => toast.id === id)
  if (index > -1) {
    const toast = toasts.value[index]
    if (toast.timeoutId) {
      clearTimeout(toast.timeoutId)
    }
    toasts.value.splice(index, 1)
  }
}

const pauseToast = (id: number) => {
  const toast = toasts.value.find(t => t.id === id)
  if (toast && !toast.isPaused && toast.timeoutId) {
    clearTimeout(toast.timeoutId)
    const elapsed = Date.now() - (toast.startTime || 0)
    toast.remainingTime = Math.max(0, toast.duration - elapsed)
    toast.isPaused = true
  }
}

const resumeToast = (id: number) => {
  const toast = toasts.value.find(t => t.id === id)
  if (toast && toast.isPaused && toast.remainingTime && toast.remainingTime > 0) {
    toast.startTime = Date.now()
    toast.isPaused = false
    const timeoutId = setTimeout(() => {
      removeToast(id)
    }, toast.remainingTime)
    toast.timeoutId = timeoutId
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
    pauseToast,
    resumeToast,
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