<template>
  <div :class="['sidebar', { 'open': isOpen, 'closed': !isOpen }]">
    <div class="sidebar-header">
      <button class="toggle-btn" @click="$emit('toggle')">
        <i class="icon">{{ isOpen ? '☰' : '☰' }}</i>
      </button>
      <h2 v-if="isOpen" class="sidebar-title">Sistema de Instituição</h2>
    </div>
    
    <nav class="sidebar-nav">
      <router-link to="/" class="nav-item">
        <i class="nav-icon">🏠</i>
        <span v-if="isOpen" class="nav-text">Home</span>
      </router-link>
      
      <router-link to="/instituicoes" class="nav-item">
        <i class="nav-icon">🏢</i>
        <span v-if="isOpen" class="nav-text">Cadastro Instituições</span>
      </router-link>
      
      <router-link to="/funcionarios" class="nav-item">
        <i class="nav-icon">👥</i>
        <span v-if="isOpen" class="nav-text">Registro</span>
      </router-link>
    </nav>
  </div>
</template>

<script setup lang="ts">
interface Props {
  isOpen: boolean
}

interface Emits {
  (e: 'toggle'): void
}

defineProps<Props>()
defineEmits<Emits>()
</script>

<style scoped>
.sidebar {
  background: #2c3e50;
  color: white;
  transition: width 0.3s ease;
  position: fixed;
  height: 100vh;
  left: 0;
  top: 0;
  z-index: 1000;
  display: flex;
  flex-direction: column;
}

.sidebar.open {
  width: 250px;
}

.sidebar.closed {
  width: 60px;
}

.sidebar-header {
  display: flex;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid #34495e;
}

.toggle-btn {
  background: none;
  border: none;
  color: white;
  font-size: 20px;
  cursor: pointer;
  padding: 5px;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.toggle-btn:hover {
  background-color: #34495e;
}

.sidebar-title {
  margin-left: 15px;
  font-size: 16px;
  font-weight: 600;
}

.sidebar-nav {
  flex: 1;
  padding: 20px 0;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s;
  white-space: nowrap;
}

.nav-item:hover {
  background-color: #34495e;
}

.nav-item.router-link-active {
  background-color: #3498db;
}

.nav-icon {
  font-size: 18px;
  width: 24px;
  text-align: center;
}

.nav-text {
  margin-left: 15px;
  font-size: 14px;
}

.sidebar.closed .nav-item {
  justify-content: center;
}
</style>