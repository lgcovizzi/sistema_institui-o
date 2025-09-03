<template>
  <teleport to="body">
    <div class="toast-container">
      <transition-group name="toast" tag="div">
        <div
          v-for="toast in toasts"
          :key="toast.id"
          :class="['toast', `toast-${toast.type}`, { 'toast-paused': toast.isPaused }]"
          @mouseenter="pauseToast(toast.id)"
          @mouseleave="resumeToast(toast.id)"
        >
          <div class="toast-icon">
            <span v-if="toast.type === 'success'">✓</span>
            <span v-else-if="toast.type === 'error'">✕</span>
            <span v-else-if="toast.type === 'warning'">⚠</span>
            <span v-else-if="toast.type === 'info'">ℹ</span>
          </div>
          <div class="toast-content">
            <div class="toast-title">{{ getTitle(toast.type) }}</div>
            <div class="toast-message">{{ toast.message }}</div>
          </div>
          <button class="toast-close" @click="removeToast(toast.id)">
            ×
          </button>
          <div class="toast-progress">
            <div 
              :class="['toast-progress-bar', `toast-progress-${toast.type}`]"
              :style="{ animationDuration: `${toast.duration}ms` }"
            ></div>
          </div>
        </div>
      </transition-group>
    </div>
  </teleport>
</template>

<script setup lang="ts">
import { useToast } from '@/composables/useToast'

const { toasts, removeToast, pauseToast, resumeToast } = useToast()

const getTitle = (type: string) => {
  const titles: Record<string, string> = {
    success: 'Sucesso',
    error: 'Erro',
    warning: 'Aviso',
    info: 'Informação'
  }
  return titles[type] || 'Notificação'
}
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
  pointer-events: none;
}

.toast {
  display: flex;
  align-items: flex-start;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  margin-bottom: 12px;
  padding: 16px;
  min-width: 320px;
  max-width: 400px;
  pointer-events: auto;
  border-left: 4px solid;
  position: relative;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  cursor: pointer;
}

.toast:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.toast-paused .toast-progress-bar {
  animation-play-state: paused;
}

.toast-success {
  border-left-color: #10b981;
}

.toast-error {
  border-left-color: #ef4444;
}

.toast-warning {
  border-left-color: #f59e0b;
}

.toast-info {
  border-left-color: #3b82f6;
}

.toast-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  margin-right: 12px;
  font-weight: bold;
  font-size: 14px;
  color: white;
}

.toast-success .toast-icon {
  background-color: #10b981;
}

.toast-error .toast-icon {
  background-color: #ef4444;
}

.toast-warning .toast-icon {
  background-color: #f59e0b;
}

.toast-info .toast-icon {
  background-color: #3b82f6;
}

.toast-content {
  flex: 1;
}

.toast-title {
  font-weight: 600;
  font-size: 14px;
  color: #1f2937;
  margin-bottom: 4px;
}

.toast-message {
  font-size: 13px;
  color: #6b7280;
  line-height: 1.4;
}

.toast-close {
  background: none;
  border: none;
  font-size: 18px;
  color: #9ca3af;
  cursor: pointer;
  padding: 0;
  margin-left: 8px;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  transition: all 0.2s;
  opacity: 0.7;
}

.toast-close:hover {
  background-color: #f3f4f6;
  color: #374151;
  opacity: 1;
  transform: scale(1.1);
}

/* Barra de progresso */
.toast-progress {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 3px;
  background-color: rgba(0, 0, 0, 0.1);
}

.toast-progress-bar {
  height: 100%;
  width: 100%;
  transform-origin: left;
  animation: toast-progress linear forwards;
}

.toast-progress-success {
  background-color: #10b981;
}

.toast-progress-error {
  background-color: #ef4444;
}

.toast-progress-warning {
  background-color: #f59e0b;
}

.toast-progress-info {
  background-color: #3b82f6;
}

@keyframes toast-progress {
  from {
    transform: scaleX(1);
  }
  to {
    transform: scaleX(0);
  }
}

/* Animações */
.toast-enter-active {
  transition: all 0.4s ease-out;
}

.toast-leave-active {
  transition: all 0.4s ease-in;
}

.toast-enter-from {
  transform: translateX(100%) scale(0.8);
  opacity: 0;
}

.toast-leave-to {
  transform: translateX(100%) scale(0.8);
  opacity: 0;
}

.toast-move {
  transition: transform 0.4s ease;
}

/* Responsividade */
@media (max-width: 768px) {
  .toast-container {
    top: 10px;
    right: 10px;
    left: 10px;
    width: auto;
  }
  
  .toast {
    min-width: auto;
    max-width: none;
    width: 100%;
    margin-bottom: 8px;
    padding: 12px;
  }
  
  .toast-title {
    font-size: 13px;
  }
  
  .toast-message {
    font-size: 12px;
  }
  
  .toast-icon {
    width: 20px;
    height: 20px;
    font-size: 12px;
    margin-right: 8px;
  }
}

@media (max-width: 480px) {
  .toast-container {
    top: 5px;
    right: 5px;
    left: 5px;
  }
  
  .toast {
    padding: 10px;
    border-radius: 6px;
  }
  
  .toast-progress {
    height: 2px;
  }
}
</style>