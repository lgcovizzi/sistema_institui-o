<template>
  <div class="form-container">
    <h2>{{ editMode ? 'Editar Departamento' : 'Cadastrar Departamento' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="instituicao">Instituição:</label>
        <select
          id="instituicao"
          v-model="departamento.instituicao_id"
          required
          class="form-control"
          @change="loadEnderecos"
        >
          <option value="">Selecione uma instituição</option>
          <option
            v-for="instituicao in instituicoes"
            :key="instituicao.id"
            :value="instituicao.id"
          >
            {{ instituicao.nome_curto }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="endereco">Endereço:</label>
        <select
          id="endereco"
          v-model="departamento.endereco_id"
          required
          class="form-control"
          :disabled="!departamento.instituicao_id"
        >
          <option value="">Selecione um endereço</option>
          <option
            v-for="endereco in enderecos"
            :key="endereco.id"
            :value="endereco.id"
          >
            {{ endereco.titulo }} - {{ endereco.cidade }}/{{ endereco.estado }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="nome">Nome:</label>
        <input
          type="text"
          id="nome"
          v-model="departamento.nome"
          required
          class="form-control"
        />
      </div>



      <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ editMode ? 'Atualizar' : 'Cadastrar' }}</button>
        <button v-if="editMode" type="button" @click="cancelEdit" class="btn btn-secondary">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: 'DepartamentoForm',
  props: {
    departamentoEdit: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      departamento: {
        instituicao_id: '',
        endereco_id: '',
        nome: ''
      },
      instituicoes: [],
      enderecos: [],
      editMode: false,
      departamentoId: null
    };
  },
  watch: {
    departamentoEdit: {
      handler(newVal) {
        if (newVal) {
          this.departamento = { ...newVal };
          this.editMode = true;
          this.departamentoId = newVal.id;
          this.loadEnderecos();
        } else {
          this.resetForm();
        }
      },
      immediate: true
    }
  },
  async mounted() {
    await this.loadInstituicoes();
  },
  methods: {
    async loadInstituicoes() {
      try {
        const response = await api.get('/instituicoes');
        this.instituicoes = response.data;
      } catch (error) {
        console.error('Erro ao carregar instituições:', error);
      }
    },
    async loadEnderecos() {
      if (!this.departamento.instituicao_id) {
        this.enderecos = [];
        return;
      }

      try {
        const response = await api.get(`/instituicoes/${this.departamento.instituicao_id}/enderecos`);
        this.enderecos = response.data;
      } catch (error) {
        console.error('Erro ao carregar endereços:', error);
      }
    },
    async submitForm() {
      try {
        let response;
        if (this.editMode) {
          response = await api.put(`/departamentos/${this.departamentoId}`, this.departamento);
          this.$emit('departamento-atualizado', response.data);
          alert('Departamento atualizado com sucesso!');
        } else {
          response = await api.post('/departamentos', this.departamento);
          this.$emit('departamento-criado', response.data);
          alert('Departamento cadastrado com sucesso!');
        }
        this.resetForm();
      } catch (error) {
        console.error('Erro ao salvar departamento:', error);
        alert('Erro ao salvar departamento. Verifique os dados e tente novamente.');
      }
    },
    resetForm() {
      this.departamento = {
        instituicao_id: '',
        endereco_id: '',
        nome: '',
        descricao: ''
      };
      this.enderecos = [];
      this.editMode = false;
      this.departamentoId = null;
      this.$emit('cancel-edit');
    },
    cancelEdit() {
      this.resetForm();
    }
  }
};
</script>

<style scoped>


.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.form-control:disabled {
  background-color: #e9ecef;
  cursor: not-allowed;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }

  .btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  .btn-primary {
    background-color: #007bff;
    color: white;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: white;
  }

  .btn-secondary:hover {
    background-color: #545b62;
  }
</style>