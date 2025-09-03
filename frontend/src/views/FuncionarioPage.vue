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
        <h1>Cadastro de Funcionários</h1>
      </div>
      
      <div class="forms-section">
        <FuncionarioForm 
          :funcionario-edit="funcionarioEmEdicao" 
          @funcionario-criado="onFuncionarioCriado"
          @funcionario-atualizado="onFuncionarioAtualizado"
          @cancel-edit="cancelarEdicao"
        />
      </div>

      <div class="dashboard-grid">
        <div class="funcionario-cards">
          <div v-for="funcionario in funcionarios" :key="funcionario.id" class="funcionario-card">
            <div class="funcionario-header">
              <h3>{{ funcionario.nome }}</h3>
              <div class="actions">
                <button @click="editarFuncionario(funcionario)" class="btn-edit">Editar</button>
                <button @click="deleteFuncionario(funcionario.id)" class="btn-delete">Deletar</button>
              </div>
            </div>
            <div class="funcionario-details">
              <p><strong>Instituição:</strong> {{ funcionario.instituicao?.nome_curto || 'N/A' }}</p>
              <p><strong>Endereço:</strong> {{ funcionario.endereco?.titulo || 'N/A' }} - {{ funcionario.endereco?.cidade || 'N/A' }} - {{ funcionario.endereco?.estado || 'N/A' }}</p>
              <p><strong>Departamento:</strong> {{ funcionario.departamento?.nome || 'N/A' }}</p>
              <p><strong>Cargo:</strong> {{ funcionario.cargo || 'N/A' }}</p>
              <p><strong>Horário:</strong> {{ funcionario.horario_trabalho || 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FuncionarioForm from '@/components/FuncionarioForm.vue'
import api from '@/services/api'

export default {
  name: 'FuncionarioPage',
  components: {
    FuncionarioForm
  },
  data() {
    return {
      funcionarios: [],
      funcionarioEmEdicao: null,
      sidebarCollapsed: false
    }
  },
  mounted() {
    this.carregarFuncionarios()
  },
  methods: {
    async carregarFuncionarios() {
      try {
        const response = await api.get('/funcionarios')
        this.funcionarios = response.data
      } catch (error) {
        console.error('Erro ao carregar funcionários:', error)
      }
    },
    onFuncionarioCriado() {
      this.carregarFuncionarios()
    },
    onFuncionarioAtualizado() {
      this.carregarFuncionarios()
      this.funcionarioEmEdicao = null
    },
    editarFuncionario(funcionario) {
      this.funcionarioEmEdicao = funcionario
    },
    async deleteFuncionario(id) {
      if (confirm('Tem certeza que deseja deletar este funcionário?')) {
        try {
          await api.delete(`/funcionarios/${id}`)
          this.carregarFuncionarios()
        } catch (error) {
          console.error('Erro ao deletar funcionário:', error)
        }
      }
    },
    cancelarEdicao() {
      this.funcionarioEmEdicao = null
    },
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

.sidebar-toggle {
  background: none;
  border: none;
  font-size: 1.5em;
  cursor: pointer;
  display: none;
}

.forms-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-bottom: 32px;
  width: 100%;
  max-width: 480px;
  align-items: center;
}

.dashboard-grid {
  display: flex;
  flex-direction: column;
  gap: 24px;
  width: 100%;
  max-width: 900px;
  align-items: center;
}

.funcionario-cards {
  display: flex;
  flex-direction: column;
  gap: 18px;
  width: 100%;
  align-items: center;
}

.funcionario-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  border-left: 6px solid #9b59b6;
  width: 100%;
  max-width: 700px;
  box-sizing: border-box;
  min-height: 180px;
}

.funcionario-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.funcionario-header h3 {
  margin: 0;
  color: #2c3e50;
}

.funcionario-details p {
  margin: 8px 0;
  color: #555;
}

.actions {
  display: flex;
  gap: 5px;
}

.btn-edit, .btn-delete {
  padding: 5px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 0.8em;
}

.btn-edit {
  background-color: #f39c12;
  color: white;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(243,156,18,0.12);
  display: flex;
  align-items: center;
  gap: 4px;
}

.btn-delete {
  background-color: #e74c3c;
  color: white;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(231,76,60,0.12);
  display: flex;
  align-items: center;
  gap: 4px;
}

.btn-edit::before {
  content: '\270E';
  font-size: 1em;
}

.btn-delete::before {
  content: '\2716';
  font-size: 1em;
}

.btn-edit:hover, .btn-delete:hover {
  opacity: 0.85;
  filter: brightness(0.95);
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
  .forms-section {
    flex-direction: column;
    gap: 12px;
    max-width: 100%;
    align-items: stretch;
  }
  .dashboard-grid {
    gap: 12px;
    max-width: 100%;
    align-items: stretch;
  }
  .funcionario-cards {
    gap: 12px;
    max-width: 100%;
    align-items: stretch;
  }
  .funcionario-card {
    padding: 12px;
    border-radius: 8px;
    max-width: 100%;
  }
  .funcionario-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
}
</style>