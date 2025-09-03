<template>
  <div class="form-container">
    <h2>{{ editMode ? 'Editar Instituição' : 'Cadastrar Instituição' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="nome_curto">Nome Curto:</label>
        <input
          type="text"
          id="nome_curto"
          v-model="instituicao.nome_curto"
          required
          maxlength="50"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="nome_longo">Nome Longo:</label>
        <input
          type="text"
          id="nome_longo"
          v-model="instituicao.nome_longo"
          required
          maxlength="255"
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
  name: 'InstituicaoForm',
  props: {
    instituicaoEdit: {
      type: Object,
      default: null
    }
  },
  inject: ['toast'],
  data() {
    return {
      instituicao: {
        nome_curto: '',
        nome_longo: ''
      },
      editMode: false,
      instituicaoId: null
    };
  },
  watch: {
    instituicaoEdit: {
      handler(newVal) {
        if (newVal) {
          this.instituicao = { ...newVal };
          this.editMode = true;
          this.instituicaoId = newVal.id;
        } else {
          this.resetForm();
        }
      },
      immediate: true
    }
  },
  methods: {
    async submitForm() {
      try {
        let response;
        if (this.editMode) {
          response = await api.put(`/instituicoes/${this.instituicaoId}`, this.instituicao);
          this.$emit('instituicao-atualizada', response.data);
          this.toast.success('Instituição atualizada com sucesso!');
        } else {
          response = await api.post('/instituicoes', this.instituicao);
          this.$emit('instituicao-criada', response.data);
          this.toast.success('Instituição cadastrada com sucesso!');
        }
        this.resetForm();
        // Recarregar a página silenciosamente
        window.location.reload();
      } catch (error) {
        console.error('Erro ao salvar instituição:', error);
        
        // Tratamento específico para erros de validação (422)
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          
          if (errors.nome_curto && errors.nome_curto.includes('already been taken')) {
            this.toast.error('Erro: O nome curto já está em uso. Por favor, escolha outro nome.');
          } else if (errors.nome_longo && errors.nome_longo.includes('already been taken')) {
            this.toast.error('Erro: O nome longo já está em uso. Por favor, escolha outro nome.');
          } else {
            // Exibe mensagens de erro de validação genéricas
            const errorMessages = Object.values(errors).flat();
            errorMessages.forEach(message => {
              this.toast.error(`Erro de validação: ${message}`);
            });
          }
        } else {
          // Mensagem genérica para outros tipos de erro
          this.toast.error('Erro ao salvar instituição. Verifique os dados e tente novamente.');
        }
      }
    },
    resetForm() {
      this.instituicao = {
        nome_curto: '',
        nome_longo: ''
      };
      this.editMode = false;
      this.instituicaoId = null;
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