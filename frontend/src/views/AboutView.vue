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
        <h1>Sobre o Sistema</h1>
      </div>
      
      <div class="about-section">
        <div class="about-card">
          <h2>Sistema de Gestão Institucional</h2>
          <p>Este sistema foi desenvolvido para gerenciar instituições, endereços, departamentos e funcionários de forma integrada e eficiente.</p>
          
          <div class="about-details">
            <h3>Funcionalidades Principais:</h3>
            <ul>
              <li><strong>Cadastro de Instituições:</strong> Registro de instituições com nome longo e curto únicos</li>
              <li><strong>Gestão de Endereços:</strong> Vinculação de múltiplos endereços por instituição</li>
              <li><strong>Departamentos:</strong> Organização hierárquica de departamentos por instituição e endereço</li>
              <li><strong>Funcionários:</strong> Cadastro completo de colaboradores com vínculo institucional</li>
            </ul>
            
            <h3>Tecnologias Utilizadas:</h3>
            <ul>
              <li>Backend: Laravel (PHP)</li>
              <li>Frontend: Vue.js 3</li>
              <li>Banco de Dados: MariaDB</li>
              <li>Containerização: Docker</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutView',
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

.about-section {
  width: 100%;
  max-width: 900px;
  display: flex;
  justify-content: center;
}

.about-card {
  background: white;
  border-radius: 16px;
  padding: 48px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  width: 100%;
}

.about-card h2 {
  color: #2c3e50;
  margin-bottom: 16px;
  font-size: 2em;
}

.about-card > p {
  color: #666;
  margin-bottom: 32px;
  font-size: 1.2em;
}

.about-details h3 {
  color: #2c3e50;
  margin: 24px 0 12px 0;
  font-size: 1.4em;
}

.about-details ul {
  margin: 0;
  padding-left: 24px;
}

.about-details li {
  margin: 8px 0;
  color: #555;
  line-height: 1.6;
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
  .about-card {
    padding: 24px;
  }
}
</style>
