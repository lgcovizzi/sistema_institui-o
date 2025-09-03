<template>
  <div class="form-container">
    <h2>{{ editMode ? 'Editar Endereço' : 'Cadastrar Endereço' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="instituicao">Instituição:</label>
        <select
          id="instituicao"
          v-model="endereco.instituicao_id"
          required
          class="form-control"
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
        <label for="titulo">Título:</label>
        <input
          type="text"
          id="titulo"
          v-model="endereco.titulo"
          required
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="cidade">Cidade:</label>
        <input
          type="text"
          id="cidade"
          v-model="endereco.cidade"
          required
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="estado">Estado:</label>
        <input
          type="text"
          id="estado"
          v-model="endereco.estado"
          required
          maxlength="2"
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
  name: 'EnderecoForm',
  props: {
    enderecoEdit: {
      type: Object,
      default: null
    }
  },
  inject: ['toast'],
  data() {
    return {
      endereco: {
        instituicao_id: '',
        titulo: '',
        cidade: '',
        estado: ''
      },
      instituicoes: [],
      editMode: false,
      enderecoId: null
    };
  },
  watch: {
    enderecoEdit: {
      handler(newVal) {
        if (newVal) {
          this.endereco = { ...newVal };
          this.editMode = true;
          this.enderecoId = newVal.id;
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
    async submitForm() {
      try {
        let response;
        if (this.editMode) {
          response = await api.put(`/enderecos/${this.enderecoId}`, this.endereco);
          this.$emit('endereco-atualizado', response.data);
          this.toast.success('Endereço atualizado com sucesso!');
        } else {
          response = await api.post('/enderecos', this.endereco);
          this.$emit('endereco-criado', response.data);
          this.toast.success('Endereço cadastrado com sucesso!');
        }
        this.resetForm();
        // Recarregar a página silenciosamente
        window.location.reload();
      } catch (error) {
        console.error('Erro ao salvar endereço:', error);
        
        // Tratamento específico para erros de validação (422)
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          
          if (errors.titulo && errors.titulo.includes('already been taken')) {
            this.toast.error('Erro: Este título de endereço já está em uso para esta instituição. Por favor, escolha outro título.');
          } else {
            // Exibe mensagens de erro de validação genéricas
            const errorMessages = Object.values(errors).flat();
            errorMessages.forEach(message => {
              this.toast.error(`Erro de validação: ${message}`);
            });
          }
        } else {
          // Mensagem genérica para outros tipos de erro
          this.toast.error('Erro ao salvar endereço. Verifique os dados e tente novamente.');
        }
      }
    },
    resetForm() {
      this.endereco = {
        instituicao_id: '',
        titulo: '',
        cidade: '',
        estado: ''
      };
      this.editMode = false;
      this.enderecoId = null;
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