<template>
  <div class="list-container">
    <h2>Funcionários Cadastrados</h2>
    <div class="cards-container">
      <div v-for="funcionario in funcionarios" :key="funcionario.id" class="card">
        <div class="card-header">
          <div class="card-actions">
            <button @click="editFuncionario(funcionario)" class="btn-edit">Editar</button>
            <button @click="deleteFuncionario(funcionario.id)" class="btn-delete">Deletar</button>
          </div>
        </div>
        <div class="card-body">
          <p><strong>CPF:</strong> {{ funcionario.cpf }}</p>
          <p v-if="funcionario.instituicao">
            <strong>Instituição:</strong> {{ funcionario.instituicao.nome_curto }}
          </p>
          <p v-if="funcionario.endereco">
            <strong>Endereço:</strong> {{ funcionario.endereco.titulo }} - {{ funcionario.endereco.cidade }}/{{ funcionario.endereco.estado }}
          </p>
          <p v-if="funcionario.departamento">
            <strong>Departamento:</strong> {{ funcionario.departamento.nome }}
          </p>
          <p v-if="funcionario.email">
            <strong>Email:</strong> {{ funcionario.email }}
          </p>
          <p v-if="funcionario.telefone">
            <strong>Telefone:</strong> {{ funcionario.telefone }}
          </p>
        </div>
      </div>
      <div v-if="funcionarios.length === 0" class="no-data">
        Nenhum funcionário cadastrado.
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/services/api.js';

export default {
  name: 'FuncionarioList',
  data() {
    return {
      funcionarios: []
    };
  },
  mounted() {
    this.loadFuncionarios();
  },
  methods: {
    async loadFuncionarios() {
      try {
        const response = await axios.get('/funcionarios');
        this.funcionarios = response.data;
      } catch (error) {
        console.error('Erro ao carregar funcionários:', error);
      }
    },
    editFuncionario(funcionario) {
      this.$emit('edit-funcionario', funcionario);
    },
    async deleteFuncionario(id) {
      if (confirm('Tem certeza que deseja deletar este funcionário?')) {
        try {
          await axios.delete(`/funcionarios/${id}`);
          this.loadFuncionarios();
        } catch (error) {
          console.error('Erro ao deletar funcionário:', error);
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
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
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

.no-data {
  text-align: center;
  color: #666;
  font-style: italic;
  grid-column: 1 / -1;
}
</style>