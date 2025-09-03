<template>
  <div class="form-container">
    <h2>{{ editMode ? 'Editar Funcionário' : 'Registro' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="instituicao">Instituição:</label>
        <select
          id="instituicao"
          v-model="funcionario.instituicao_id"
          required
          class="form-control"
          @change="loadEnderecosEDepartamentos"
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
          v-model="funcionario.endereco_id"
          required
          class="form-control"
          :disabled="!funcionario.instituicao_id"
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
        <label for="departamento">Departamento:</label>
        <select
          id="departamento"
          v-model="funcionario.departamento_id"
          required
          class="form-control"
          :disabled="!funcionario.instituicao_id"
        >
          <option value="">Selecione um departamento</option>
          <option
            v-for="departamento in departamentos"
            :key="departamento.id"
            :value="departamento.id"
          >
            {{ departamento.nome }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="nome">Nome:</label>
        <input
          id="nome"
          v-model="funcionario.nome"
          type="text"
          required
          class="form-control"
          placeholder="Digite o nome"
        >
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
  name: 'FuncionarioForm',
  props: {
    funcionarioEdit: {
      type: Object,
      default: null
    }
  },
  inject: ['toast'],
  data() {
    return {
      funcionario: {
        instituicao_id: '',
        endereco_id: '',
        departamento_id: '',
        nome: ''
      },
      instituicoes: [],
      enderecos: [],
      departamentos: [],
      editMode: false,
      funcionarioId: null
    };
  },
  watch: {
    funcionarioEdit: {
      handler(newVal) {
        if (newVal) {
          this.funcionario = { ...newVal };
          this.editMode = true;
          this.funcionarioId = newVal.id;
          this.loadEnderecosEDepartamentos();
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
        this.toast.error('Erro ao carregar instituições.');
      }
    },
    async loadEnderecos() {
      if (!this.funcionario.instituicao_id) {
        this.enderecos = [];
        return;
      }

      try {
        const response = await api.get(`/instituicoes/${this.funcionario.instituicao_id}/enderecos`);
        this.enderecos = response.data;
      } catch (error) {
        console.error('Erro ao carregar endereços:', error);
        this.toast.error('Erro ao carregar endereços.');
      }
    },
    async loadDepartamentos() {
      if (!this.funcionario.instituicao_id) {
        this.departamentos = [];
        return;
      }

      try {
        const response = await api.get(`/instituicoes/${this.funcionario.instituicao_id}/departamentos`);
        this.departamentos = response.data;
      } catch (error) {
        console.error('Erro ao carregar departamentos:', error);
        this.toast.error('Erro ao carregar departamentos.');
      }
    },
    async loadEnderecosEDepartamentos() {
      await this.loadEnderecos();
      await this.loadDepartamentos();
    },
    async submitForm() {
      try {
        let response;
        if (this.editMode) {
          response = await api.put(`/funcionarios/${this.funcionarioId}`, this.funcionario);
          this.$emit('funcionario-atualizado', response.data);
          this.toast.success('Funcionário atualizado com sucesso!');
        } else {
          response = await api.post('/funcionarios', this.funcionario);
          this.$emit('funcionario-criado', response.data);
          this.toast.success('Funcionário cadastrado com sucesso!');
        }
        this.resetForm();
        // Recarregar a página silenciosamente
        window.location.reload();
      } catch (error) {
        console.error('Erro ao salvar funcionário:', error);
        
        // Tratamento específico para erros de validação (422)
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          
          // Exibe mensagens de erro de validação
          const errorMessages = Object.values(errors).flat();
          errorMessages.forEach(message => {
            this.toast.error(`Erro de validação: ${message}`);
          });
        } else {
          // Mensagem genérica para outros tipos de erro
          this.toast.error('Erro ao salvar funcionário. Verifique os dados e tente novamente.');
        }
      }
    },
    resetForm() {
      this.funcionario = {
        instituicao_id: '',
        endereco_id: '',
        departamento_id: '',
        nome: ''
      };
      this.enderecos = [];
      this.departamentos = [];
      this.editMode = false;
      this.funcionarioId = null;
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