<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="instituicao">Instituição</label>
      <select id="instituicao" v-model="selectedInstituicao" required>
        <option v-for="instituicao in instituicoes" :key="instituicao.id" :value="instituicao.id">
          {{ instituicao.nome_curto }}
        </option>
      </select>
    </div>
    <div class="form-group">
      <label for="endereco">Endereço</label>
      <select id="endereco" v-model="departamento.endereco_id" required :disabled="!selectedInstituicao">
        <option v-for="endereco in enderecos" :key="endereco.id" :value="endereco.id">
          {{ endereco.titulo }}
        </option>
      </select>
    </div>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input id="nome" v-model="departamento.nome" type="text" required />
    </div>
    <button type="submit">Salvar</button>
  </form>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { useInstituicaoStore } from '@/stores/instituicao';
import { useEnderecoStore } from '@/stores/endereco';
import type { Departamento, Endereco } from '@/types';

const instituicaoStore = useInstituicaoStore();
const enderecoStore = useEnderecoStore();
const { instituicoes } = instituicaoStore;
const { enderecos } = enderecoStore;

const selectedInstituicao = ref<number | null>(null);

onMounted(() => {
  instituicaoStore.fetchInstituicoes();
});

watch(selectedInstituicao, (newVal) => {
  if (newVal) {
    enderecoStore.fetchEnderecos(newVal);
  }
});

const departamento = ref<Partial<Departamento>>({
  endereco_id: null,
  nome: ''
});

const emit = defineEmits(['submit']);

const submitForm = () => {
  emit('submit', departamento.value);
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