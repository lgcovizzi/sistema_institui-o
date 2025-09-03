<template>
  <div class="dashboard">
    <div class="sidebar" :class="{ collapsed: sidebarCollapsed }">
      <h2>Sistema de Instituição</h2>
      <nav>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/cadastro">Cadastro Instituições</router-link></li>
          <li><router-link to="/funcionarios">Registro</router-link></li>
        </ul>
      </nav>
    </div>
    
    <div class="main-content" :class="{ expanded: sidebarCollapsed }">
      <div class="header">
        <h1>Sistema de Cadastro Institucional</h1>
      </div>
      
      <div class="forms-section">
        <InstituicaoForm 
          :instituicao-edit="instituicaoEmEdicao" 
          @instituicao-criada="onInstituicaoCriada"
          @instituicao-atualizada="onInstituicaoAtualizada"
          @cancel-edit="cancelarEdicao"
        />
        <EnderecoForm 
          :endereco-edit="enderecoEmEdicao"
          @endereco-criado="onEnderecoCriado"
          @endereco-atualizado="onEnderecoAtualizado"
          @cancel-edit="cancelarEdicao"
        />
        <DepartamentoForm 
          :departamento-edit="departamentoEmEdicao"
          @departamento-criado="onDepartamentoCriado"
          @departamento-atualizado="onDepartamentoAtualizado"
          @cancel-edit="cancelarEdicao"
        />
      </div>

      <div class="dashboard-grid">
        <!-- Seção de Instituições -->
        <div class="section">
          <h2 class="section-title">Instituições Cadastradas</h2>
          <div class="institution-cards">
            <div v-for="instituicao in instituicoes" :key="instituicao.id" class="institution-card">
              <div class="institution-header">
                <h3>{{ instituicao.nome_curto }}</h3>
                <div class="actions">
                  <button @click="editarInstituicao(instituicao)" class="btn-edit">Editar</button>
                  <button @click="deleteInstituicao(instituicao.id)" class="btn-delete">Deletar</button>
                </div>
              </div>
              <p><strong>Nome Completo:</strong> {{ instituicao.nome_longo }}</p>
              
              <div class="addresses-section">
                <h4>Endereços Cadastrados</h4>
                <div class="address-cards">
                  <div v-for="endereco in instituicao.enderecos" :key="endereco.id" class="address-card">
                    <div class="address-header">
                      <h5>{{ endereco.titulo }}</h5>
                      <div class="actions">
                        <button @click="editarEndereco(endereco)" class="btn-edit">Editar</button>
                        <button @click="deleteEndereco(endereco.id)" class="btn-delete">Deletar</button>
                      </div>
                    </div>
                    <p>{{ endereco.cidade }} - {{ endereco.estado }}</p>
                    
                    <div class="departments-section">
                      <h5>Departamentos Cadastrados</h5>
                      <div class="department-cards">
                        <div v-for="departamento in endereco.departamentos" :key="departamento.id" class="department-card">
                          <div class="department-header">
                            <h6>{{ departamento.nome }}</h6>
                            <div class="actions">
                              <button @click="editarDepartamento(departamento)" class="btn-edit">Editar</button>
                              <button @click="deleteDepartamento(departamento.id)" class="btn-delete">Deletar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>
  </div>
</template>

<script>
import InstituicaoForm from '@/components/InstituicaoForm.vue';
import EnderecoForm from '@/components/EnderecoForm.vue';
import DepartamentoForm from '@/components/DepartamentoForm.vue';
import api from '@/services/api';

export default {
  name: 'CadastroPage',
  components: {
    InstituicaoForm,
    EnderecoForm,
    DepartamentoForm
  },
  data() {
    return {
      instituicoes: [],
      todosEnderecos: [],
      todosDepartamentos: [],
      instituicaoEmEdicao: null,
      enderecoEmEdicao: null,
      departamentoEmEdicao: null,
      sidebarCollapsed: false
    };
  },
  mounted() {
    this.carregarInstituicoes();
    this.carregarEnderecos();
    this.carregarDepartamentos();
  },
  methods: {
    async carregarInstituicoes() {
      try {
        const response = await api.get('/instituicoes');
        this.instituicoes = response.data;
      } catch (error) {
        console.error('Erro ao carregar instituições:', error);
      }
    },
    async carregarEnderecos() {
      try {
        const response = await api.get('/enderecos');
        this.todosEnderecos = response.data;
      } catch (error) {
        console.error('Erro ao carregar endereços:', error);
      }
    },
    async carregarDepartamentos() {
      try {
        const response = await api.get('/departamentos');
        this.todosDepartamentos = response.data;
      } catch (error) {
        console.error('Erro ao carregar departamentos:', error);
      }
    },
    onInstituicaoCriada() {
      this.carregarInstituicoes();
    },
    onEnderecoCriado() {
      this.carregarInstituicoes();
      this.carregarEnderecos();
    },
    onDepartamentoCriado() {
      this.carregarInstituicoes();
      this.carregarDepartamentos();
    },
    onInstituicaoAtualizada() {
      this.carregarInstituicoes();
      this.carregarEnderecos();
      this.carregarDepartamentos();
      this.cancelarEdicao();
    },
    onEnderecoAtualizado() {
      this.carregarInstituicoes();
      this.carregarEnderecos();
      this.cancelarEdicao();
    },
    onDepartamentoAtualizado() {
      this.carregarInstituicoes();
      this.carregarDepartamentos();
      this.cancelarEdicao();
    },
    editarInstituicao(instituicao) {
      console.log('Editando instituição:', instituicao);
      this.cancelarEdicao();
      this.instituicaoEmEdicao = instituicao;
    },
    editarEndereco(endereco) {
      console.log('Editando endereço:', endereco);
      this.cancelarEdicao();
      this.enderecoEmEdicao = endereco;
    },
    editarDepartamento(departamento) {
      console.log('Editando departamento:', departamento);
      this.cancelarEdicao();
      this.departamentoEmEdicao = departamento;
    },
    async deleteInstituicao(id) {
      if (confirm('Tem certeza que deseja deletar esta instituição?')) {
        try {
          await api.delete(`/instituicoes/${id}`);
          this.carregarInstituicoes();
          this.carregarEnderecos();
          this.carregarDepartamentos();
        } catch (error) {
          console.error('Erro ao deletar instituição:', error);
        }
      }
    },
    async deleteEndereco(id) {
      if (confirm('Tem certeza que deseja deletar este endereço?')) {
        try {
          await api.delete(`/enderecos/${id}`);
          this.carregarInstituicoes();
          this.carregarEnderecos();
          this.carregarDepartamentos();
        } catch (error) {
          console.error('Erro ao deletar endereço:', error);
        }
      }
    },
    async deleteDepartamento(id) {
      if (confirm('Tem certeza que deseja deletar este departamento?')) {
        try {
          await api.delete(`/departamentos/${id}`);
          this.carregarInstituicoes();
          this.carregarDepartamentos();
        } catch (error) {
          console.error('Erro ao deletar departamento:', error);
        }
      }
    },
    cancelarEdicao() {
      this.instituicaoEmEdicao = null;
      this.enderecoEmEdicao = null;
      this.departamentoEmEdicao = null;
    },
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
    }
  }
};
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

.form-container {
  width: 100%;
  margin: 0;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-sizing: border-box;
}

.dashboard-grid {
  display: flex;
  flex-direction: column;
  gap: 24px;
  width: 100%;
  max-width: 900px;
  align-items: center;
}

.institution-cards {
  display: flex;
  flex-direction: column;
  gap: 18px;
  width: 100%;
  align-items: center;
}

.institution-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  border-left: 6px solid #3498db;
  width: 100%;
  max-width: 700px;
  box-sizing: border-box;
  min-height: 180px;
}

.institution-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.institution-header h3 {
  margin: 0;
  color: #2c3e50;
}

.addresses-section {
  margin-top: 24px;
  padding-left: 24px;
  border-left: 3px solid #3498db;
  width: 100%;
}

.address-cards {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin-top: 14px;
  width: 100%;
  align-items: center;
}

.address-card {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 18px;
  border-left: 5px solid #2ecc71;
  width: 100%;
  max-width: 600px;
  box-sizing: border-box;
  min-height: 100px;
}

.address-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.address-header h5 {
  margin: 0;
  color: #2c3e50;
}

.departments-section {
  margin-top: 18px;
  padding-left: 18px;
  border-left: 3px solid #2ecc71;
  width: 100%;
}

.department-cards {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
  width: 100%;
  align-items: center;
}

.department-card {
  background: #fff;
  border-radius: 8px;
  padding: 14px;
  border-left: 5px solid #e74c3c;
  width: 100%;
  max-width: 400px;
  box-sizing: border-box;
  min-height: 60px;
}

.department-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 5px;
}

.department-header h6 {
  margin: 0;
  color: #2c3e50;
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
  .sidebar-toggle {
    display: block;
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
  .institution-cards {
    gap: 12px;
    max-width: 100%;
    align-items: stretch;
  }
  .institution-card {
    padding: 20px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f8fafc 80%, #e3eafc 100%);
    box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
    border-left: 6px solid #3498db;
    margin-bottom: 24px;
    transition: box-shadow 0.2s, transform 0.2s;
    position: relative;
  }
  .institution-card:hover {
    box-shadow: 0 8px 32px rgba(44, 62, 80, 0.16);
    transform: translateY(-2px) scale(1.01);
  }
  .addresses-section {
    padding-left: 24px;
    border-left: 4px solid #2ecc71;
    margin-top: 18px;
  }
  .address-cards {
    gap: 16px;
    max-width: 100%;
    align-items: stretch;
    margin-top: 10px;
  }
  .address-card {
    padding: 16px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9fa 80%, #eafaf1 100%);
    box-shadow: 0 2px 12px rgba(46, 204, 113, 0.08);
    border-left: 5px solid #2ecc71;
    margin-bottom: 12px;
    position: relative;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .address-card:hover {
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.16);
    transform: translateY(-1px) scale(1.01);
  }
  .departments-section {
    padding-left: 18px;
    border-left: 3px solid #e74c3c;
    margin-top: 12px;
  }
  .department-cards {
    gap: 10px;
    max-width: 100%;
    align-items: stretch;
    margin-top: 8px;
  }
  .department-card {
    padding: 12px;
    border-radius: 8px;
    background: linear-gradient(135deg, #fff 80%, #fbeaea 100%);
    box-shadow: 0 2px 8px rgba(231, 76, 60, 0.08);
    border-left: 5px solid #e74c3c;
    margin-bottom: 8px;
    position: relative;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .department-card:hover {
    box-shadow: 0 4px 16px rgba(231, 76, 60, 0.16);
    transform: translateY(-1px) scale(1.01);
  }
  .institution-header,
  .address-header,
  .department-header {
    flex-direction: row;
    align-items: center;
    gap: 16px;
  }
  .institution-header h3, .address-header h5, .department-header h6 {
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .actions button {
    border-radius: 6px;
    font-size: 14px;
    padding: 6px 14px;
    margin-left: 8px;
    box-shadow: 0 1px 2px rgba(44,62,80,0.04);
    transition: background 0.2s, transform 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .btn-edit {
    background: #f9c846;
    color: #fff;
    border: none;
    font-weight: 600;
  }
  .btn-edit:hover {
    background: #f7b731;
    transform: scale(1.05);
  }
  .btn-delete {
    background: #e74c3c;
    color: #fff;
    border: none;
    font-weight: 600;
  }
  .btn-delete:hover {
    background: #c0392b;
    transform: scale(1.05);
  }
  .addresses-section h4,
  .departments-section h5 {
    font-weight: 600;
    color: #3498db;
    margin-bottom: 8px;
    margin-top: 0;
  }
  .address-header h5 {
    color: #2ecc71;
  }
  .department-header h6 {
    color: #e74c3c;
  }
  .institution-header h3::before {
    content: "🏢 ";
    font-size: 18px;
  }
  .address-header h5::before {
    content: "📍 ";
    font-size: 16px;
  }
  .department-header h6::before {
    content: "🏢 ";
    font-size: 15px;
  }
  .actions .btn-edit::before {
    content: "\1F58C ";
    font-size: 15px;
    margin-right: 2px;
  }
  .actions .btn-delete::before {
    content: "\2716 ";
    font-size: 15px;
    margin-right: 2px;
  }
}

</style>