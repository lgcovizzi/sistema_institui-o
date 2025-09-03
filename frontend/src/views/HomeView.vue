<template>
  <div class="dashboard">
    <div class="sidebar" :class="{ collapsed: sidebarCollapsed }">
      <h2>Sistema de Instituição</h2>
      <nav>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/cadastro">Cadastro Instituições</router-link></li>
          <li><router-link to="/funcionarios">Cadastro Funcionários</router-link></li>
        </ul>
      </nav>
    </div>
    
    <div class="main-content" :class="{ expanded: sidebarCollapsed }">
      <div class="header">
        <h1>Sistema de Instituição</h1>
      </div>
      
      <div class="welcome-section">
        <div class="welcome-card">
          <h2>Bem-vindo ao Sistema de Instituição</h2>
          <p>Este sistema permite gerenciar instituições, endereços, departamentos e funcionários de forma integrada.</p>
          <div class="features">
            <div class="feature">
              <h3>🏢 Instituições</h3>
              <p>Cadastre e gerencie instituições com nome longo e curto únicos</p>
            </div>
            <div class="feature">
              <h3>📍 Endereços</h3>
              <p>Adicione múltiplos endereços para cada instituição</p>
            </div>
            <div class="feature">
              <h3>🏢 Departamentos</h3>
              <p>Crie departamentos vinculados a instituições e endereços</p>
            </div>
            <div class="feature">
              <h3>👥 Funcionários</h3>
              <p>Cadastre funcionários com vínculo a instituições, endereços e departamentos</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
  data() {
    return {
      sidebarCollapsed: false
    }
  }
}
</script>

<style scoped>
.dashboard {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: white;
  padding: 32px 16px;
  transition: transform 0.3s ease;
  position: fixed;
  height: 100vh;
  left: 0;
  top: 0;
  z-index: 1000;
  box-shadow: 2px 0 12px rgba(0,0,0,0.08);
}

.sidebar.collapsed {
  transform: translateX(-220px);
}

.sidebar h2 {
  margin-bottom: 32px;
  font-size: 1.4em;
  font-weight: 700;
  letter-spacing: 1px;
  text-align: center;
}

.sidebar nav ul {
  list-style: none;
  padding: 0;
}

.sidebar nav ul li {
  margin-bottom: 15px;
}

.sidebar nav ul li a {
  color: white;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 1em;
  transition: background-color 0.3s;
}

.sidebar nav ul li a:hover {
  background-color: #34495e;
}

.main-content {
  flex: 1;
  margin-left: 250px;
  padding: 32px 0;
  background-color: #f5f5f5;
  transition: margin-left 0.3s ease;
  width: calc(100% - 250px);
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.main-content.expanded {
  margin-left: 30px;
  width: calc(100% - 30px);
}

.header {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 32px;
  background: white;
  padding: 32px;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  font-size: 1.6em;
  font-weight: 700;
  letter-spacing: 1px;
}

.welcome-section {
  width: 100%;
  max-width: 900px;
  display: flex;
  justify-content: center;
}

.welcome-card {
  background: white;
  border-radius: 16px;
  padding: 48px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  text-align: center;
  width: 100%;
}

.welcome-card h2 {
  color: #2c3e50;
  margin-bottom: 16px;
  font-size: 2em;
}

.welcome-card > p {
  color: #666;
  margin-bottom: 48px;
  font-size: 1.2em;
}

.features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 24px;
}

.feature {
  background: #f8f9fa;
  padding: 24px;
  border-radius: 12px;
  border-left: 4px solid #3498db;
}

.feature h3 {
  margin: 0 0 12px 0;
  color: #2c3e50;
}

.feature p {
  margin: 0;
  color: #555;
  font-size: 0.9em;
}

.sidebar nav ul li a {
  position: relative;
}
.sidebar nav ul li:nth-child(1) a::before {
  content: '\1F3E0';
  margin-right: 8px;
}
.sidebar nav ul li:nth-child(2) a::before {
  content: '\1F4C4';
  margin-right: 8px;
}
.sidebar nav ul li:nth-child(3) a::before {
  content: '\1F464';
  margin-right: 8px;
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
    box-shadow: none;
    padding: 16px 4px;
  }
  .sidebar.collapsed {
    transform: translateX(-100%);
  }
  .main-content {
    margin-left: 0;
    padding: 8px 0;
  }
  .main-content.expanded {
    margin-left: 0;
  }
  .welcome-card {
    padding: 24px;
  }
  .features {
    grid-template-columns: 1fr;
  }
}
</style>
