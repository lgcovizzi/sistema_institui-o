<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="instituicao">Instituição</label>
      <select id="instituicao" v-model="endereco.instituicao_id" required>
        <option v-for="instituicao in instituicoes" :key="instituicao.id" :value="instituicao.id">
          {{ instituicao.nome_curto }}
        </option>
      </select>
    </div>
    <div class="form-group">
      <label for="titulo">Título</label>
      <input id="titulo" v-model="endereco.titulo" type="text" required />
    </div>
    <div class="form-group">
      <label for="cidade">Cidade</label>
      <input id="cidade" v-model="endereco.cidade" type="text" required />
    </div>
    <div class="form-group">
      <label for="estado">Estado</label>
      <input id="estado" v-model="endereco.estado" type="text" required />
    </div>
    <button type="submit">Salvar</button>
  </form>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useInstituicaoStore } from '@/stores/instituicao';
import type { Endereco } from '@/types';

const instituicaoStore = useInstituicaoStore();
const { instituicoes } = instituicaoStore;

onMounted(() => {
  instituicaoStore.fetchInstituicoes();
});

const endereco = ref<Partial<Endereco>>({
  instituicao_id: null,
  titulo: '',
  cidade: '',
  estado: ''
});

const emit = defineEmits(['submit']);

const submitForm = () => {
  emit('submit', endereco.value);
};
</script>

<style scoped>
.form-group {
  margin-bottom: 15px;
}
label {
  display: block;
  margin-bottom: 5px;
}
input, select {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}
</style>