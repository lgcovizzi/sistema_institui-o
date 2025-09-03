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
          alert('Instituição atualizada com sucesso!');
        } else {
          response = await api.post('/instituicoes', this.instituicao);
          this.$emit('instituicao-criada', response.data);
          alert('Instituição cadastrada com sucesso!');
        }
        this.resetForm();
      } catch (error) {
        console.error('Erro ao salvar instituição:', error);
        alert('Erro ao salvar instituição. Verifique os dados e tente novamente.');
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