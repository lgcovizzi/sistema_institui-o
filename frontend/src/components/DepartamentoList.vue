<template>
  <div class="list-container">
    <h2>Departamentos Cadastrados</h2>
    <div class="cards-container">
      <div v-for="departamento in departamentos" :key="departamento.id" class="card">
        <div class="card-header">
          <h3>{{ departamento.nome }}</h3>
          <div class="card-actions">
            <button @click="editDepartamento(departamento)" class="btn-edit">Editar</button>
            <button @click="deleteDepartamento(departamento.id)" class="btn-delete">Deletar</button>
          </div>
        </div>
        <div class="card-body">
          <p v-if="departamento.instituicao">
            <strong>Instituição:</strong> {{ departamento.instituicao.nome_curto }}
          </p>
          <p v-if="departamento.descricao">
            <strong>Descrição:</strong> {{ departamento.descricao }}
          </p>
          <p v-if="departamento.endereco">
            <strong>Endereço:</strong> {{ departamento.endereco.titulo }} - {{ departamento.endereco.cidade }}/{{ departamento.endereco.estado }}
          </p>
        </div>
      </div>
      <div v-if="departamentos.length === 0" class="no-data">
        Nenhum departamento cadastrado.
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/services/api.js';

export default {
  name: 'DepartamentoList',
  data() {
    return {
      departamentos: []
    };
  },
  mounted() {
    this.loadDepartamentos();
  },
  methods: {
    async loadDepartamentos() {
      try {
        const response = await axios.get('/departamentos');
        this.departamentos = response.data;
      } catch (error) {
        console.error('Erro ao carregar departamentos:', error);
      }
    },
    editDepartamento(departamento) {
      this.$emit('edit-departamento', departamento);
    },
    async deleteDepartamento(id) {
      if (confirm('Tem certeza que deseja deletar este departamento?')) {
        try {
          await axios.delete(`/departamentos/${id}`);
          this.loadDepartamentos();
        } catch (error) {
          console.error('Erro ao deletar departamento:', error);
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

.no-data {
  text-align: center;
  color: #666;
  font-style: italic;
  grid-column: 1 / -1;
}
</style>