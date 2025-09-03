<template>
  <div class="list-container">
    <h2>Instituições Cadastradas</h2>
    <div class="cards-container">
      <div v-for="instituicao in instituicoes" :key="instituicao.id" class="card">
        <div class="card-header">
          <h3>{{ instituicao.nome_curto }}</h3>
          <div class="card-actions">
            <button @click="editInstituicao(instituicao)" class="btn-edit">Editar</button>
            <button @click="deleteInstituicao(instituicao.id)" class="btn-delete">Deletar</button>
          </div>
        </div>
        <div class="card-body">
          <p><strong>Nome Completo:</strong> {{ instituicao.nome_longo }}</p>
          <div v-if="instituicao.enderecos && instituicao.enderecos.length > 0">
            <strong>Endereços:</strong>
            <ul>
              <li v-for="endereco in instituicao.enderecos" :key="endereco.id">
                {{ endereco.titulo }} - {{ endereco.cidade }}/{{ endereco.estado }}
              </li>
            </ul>
          </div>
          <div v-if="instituicao.departamentos && instituicao.departamentos.length > 0">
            <strong>Departamentos:</strong>
            <ul>
              <li v-for="departamento in instituicao.departamentos" :key="departamento.id">
                {{ departamento.nome }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div v-if="instituicoes.length === 0" class="no-data">
        Nenhuma instituição cadastrada.
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/services/api.js';

export default {
  name: 'InstituicaoList',
  data() {
    return {
      instituicoes: []
    };
  },
  mounted() {
    this.loadInstituicoes();
  },
  methods: {
    async loadInstituicoes() {
      try {
        const response = await axios.get('/instituicoes');
        this.instituicoes = response.data;
      } catch (error) {
        console.error('Erro ao carregar instituições:', error);
      }
    },
    editInstituicao(instituicao) {
      this.$emit('edit-instituicao', instituicao);
    },
    async deleteInstituicao(id) {
      if (confirm('Tem certeza que deseja deletar esta instituição?')) {
        try {
          await axios.delete(`/instituicoes/${id}`);
          this.loadInstituicoes();
        } catch (error) {
          console.error('Erro ao deletar instituição:', error);
        }
      }
    }
  }
};
</script>

<style scoped>
.list-container {
  max-width: 1200px;
  margin: 20px auto;
  padding: 20px;
}

.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 20px;
}

.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.card-header h3 {
  margin: 0;
  color: #333;
}

.card-actions {
  display: flex;
  gap: 10px;
}

.btn-edit, .btn-delete {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
}

.btn-edit {
  background-color: #007bff;
  color: white;
}

.btn-delete {
  background-color: #dc3545;
  color: white;
}

.card-body p {
  margin: 5px 0;
}

.card-body ul {
  margin: 5px 0;
  padding-left: 20px;
}

.no-data {
  text-align: center;
  color: #666;
  font-style: italic;
  grid-column: 1 / -1;
}
</style>