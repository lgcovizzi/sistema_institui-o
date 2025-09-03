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
          <h2>Bem-vindo ao Sistema de Gestão Institucional</h2>
          <p>Este sistema permite gerenciar instituições, endereços, departamentos e funcionários de forma integrada.</p>
          
          <div class="features-grid">
            <div class="feature-card">
              <h3>🏢 Instituições</h3>
              <p>Cadastre e gerencie instituições com nome curto e nome longo.</p>
              <router-link to="/cadastro" class="btn-primary">Acessar Cadastro</router-link>
            </div>
            
            <div class="feature-card">
              <h3>📍 Endereços</h3>
              <p>Adicione múltiplos endereços para cada instituição.</p>
              <router-link to="/cadastro" class="btn-primary">Gerenciar Endereços</router-link>
            </div>
            
            <div class="feature-card">
              <h3>🏢 Departamentos</h3>
              <p>Crie departamentos vinculados a instituições e endereços.</p>
              <router-link to="/cadastro" class="btn-primary">Ver Departamentos</router-link>
            </div>
            
            <div class="feature-card">
              <h3>👥 Funcionários</h3>
              <p>Cadastre funcionários com cargo e horário de trabalho.</p>
              <router-link to="/funcionarios" class="btn-primary">Cadastrar Funcionários</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      sidebarCollapsed: false
    }
  },
  methods: {
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed
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
  padding: 20px;
  transition: transform 0.3s ease;
  position: fixed;
  height: 100vh;
  left: 0;
  top: 0;
  z-index: 1000;
}

.sidebar.collapsed {
  transform: translateX(-220px);
}

.sidebar h2 {
  margin-bottom: 30px;
  font-size: 1.2em;
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
  display: block;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.sidebar nav ul li a:hover {
  background-color: #34495e;
}

.main-content {
  flex: 1;
  margin-left: 250px;
  padding: 20px;
  background-color: #f5f5f5;
  transition: margin-left 0.3s ease;
}

.main-content.expanded {
  margin-left: 30px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.sidebar-toggle {
  background: none;
  border: none;
  font-size: 1.5em;
  cursor: pointer;
  display: none;
}

.welcome-section {
  max-width: 1200px;
  margin: 0 auto;
}

.welcome-card {
  background: white;
  border-radius: 8px;
  padding: 40px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  text-align: center;
}

.welcome-card h2 {
  color: #2c3e50;
  margin-bottom: 20px;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-top: 40px;
  width: 100%;
}

.feature-card {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  transition: transform 0.3s ease;
  min-height: 200px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.feature-card:hover {
  transform: translateY(-5px);
}

.feature-card h3 {
  color: #2c3e50;
  margin-bottom: 15px;
}

.feature-card p {
  color: #555;
  margin-bottom: 20px;
}

.btn-primary {
  background-color: #3498db;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s;
}

.btn-primary:hover {
  background-color: #2980b9;
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
  }
  
  .sidebar.collapsed {
    transform: translateX(-100%);
  }
  
  .main-content {
    margin-left: 0;
  }
  
  .main-content.expanded {
    margin-left: 0;
  }
  
  .sidebar-toggle {
    display: block;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
  }
}
</style>