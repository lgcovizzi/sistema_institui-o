<template>
  <div class="list-container">
    <h2>Endereços Cadastrados</h2>
    <div class="cards-container">
      <div v-for="endereco in enderecos" :key="endereco.id" class="card">
        <div class="card-header">
          <h3>{{ endereco.titulo }}</h3>
          <div class="card-actions">
            <button @click="editEndereco(endereco)" class="btn-edit">Editar</button>
            <button @click="deleteEndereco(endereco.id)" class="btn-delete">Deletar</button>
          </div>
        </div>
        <div class="card-body">
          <p><strong>Cidade:</strong> {{ endereco.cidade }}</p>
          <p><strong>Estado:</strong> {{ endereco.estado }}</p>
          <p v-if="endereco.instituicao">
            <strong>Instituição:</strong> {{ endereco.instituicao.nome_curto }}
          </p>
        </div>
      </div>
      <div v-if="enderecos.length === 0" class="no-data">
        Nenhum endereço cadastrado.
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/services/api.js';

export default {
  name: 'EnderecoList',
  data() {
    return {
      enderecos: []
    };
  },
  mounted() {
    this.loadEnderecos();
  },
  methods: {
    async loadEnderecos() {
      try {
        const response = await axios.get('/enderecos');
        this.enderecos = response.data;
      } catch (error) {
        console.error('Erro ao carregar endereços:', error);
      }
    },
    editEndereco(endereco) {
      this.$emit('edit-endereco', endereco);
    },
    async deleteEndereco(id) {
      if (confirm('Tem certeza que deseja deletar este endereço?')) {
        try {
          await axios.delete(`/enderecos/${id}`);
          this.loadEnderecos();
        } catch (error) {
          console.error('Erro ao deletar endereço:', error);
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
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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