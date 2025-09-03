<script setup lang="ts">
import { RouterView } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import { ref } from 'vue'

const isSidebarOpen = ref(true)
</script>

<template>
  <div class="app">
    <Sidebar :is-open="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
    <main :class="{ 'sidebar-open': isSidebarOpen, 'sidebar-closed': !isSidebarOpen }">
      <RouterView />
    </main>
  </div>
</template>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  background-color: #f5f5f5;
}

a {
  text-decoration: none;
}

ul {
  list-style: none;
}

.app {
  display: flex;
  min-height: 100vh;
}

main {
  flex: 1;
  transition: margin-left 0.3s ease;
  padding: 20px;
}

main.sidebar-open {
  margin-left: 250px;
}

main.sidebar-closed {
  margin-left: 60px;
}
</style>
