<template>
  <div class="cadastro-view">
    <div class="forms-container">
      <div class="form-section">
        <h2>Instituição</h2>
        <InstituicaoForm @submit="saveInstituicao" :loading="formLoading" />
      </div>
      <div class="form-section">
        <h2>Endereço</h2>
        <EnderecoForm @submit="saveEndereco" />
      </div>
      <div class="form-section">
        <h2>Departamento</h2>
        <DepartamentoForm @submit="saveDepartamento" />
      </div>
    </div>

    <div class="list-container">
      <div v-if="loading" class="loading">Carregando...</div>
      <div v-else-if="error" class="error">{{ error }}</div>
      <div v-else>
        <InstituicaoCard
          v-for="instituicao in instituicoes"
          :key="instituicao.id"
          :instituicao="instituicao"
          @edit="editInstituicao"
          @delete="deleteInstituicao"
          @editEndereco="editEndereco"
          @deleteEndereco="deleteEndereco"
          @editDepartamento="editDepartamento"
          @deleteDepartamento="deleteDepartamento"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useInstituicaoStore } from '@/stores/instituicao';
import { useEnderecoStore } from '@/stores/endereco';
import { useDepartamentoStore } from '@/stores/departamento';
import { useAppToast } from '@/composables/useToast';
import InstituicaoForm from '@/components/InstituicaoForm.vue';
import EnderecoForm from '@/components/EnderecoForm.vue';
import DepartamentoForm from '@/components/DepartamentoForm.vue';
import InstituicaoCard from '@/components/InstituicaoCard.vue';
import type { Instituicao, Endereco, Departamento } from '@/types';

const instituicaoStore = useInstituicaoStore();
const enderecoStore = useEnderecoStore();
const departamentoStore = useDepartamentoStore();
const { showSuccess, showError } = useAppToast();

const { instituicoes, loading, error } = storeToRefs(instituicaoStore);

const formLoading = ref(false);

onMounted(async () => {
  await loadInstituicoes();
});

const loadInstituicoes = async () => {
  try {
    await instituicaoStore.fetchInstituicoes();
    for (const instituicao of instituicoes.value) {
      await enderecoStore.fetchEnderecos(instituicao.id);
      instituicao.enderecos = enderecoStore.enderecos;
      
      for (const endereco of instituicao.enderecos || []) {
        await departamentoStore.fetchDepartamentos(endereco.id);
        endereco.departamentos = departamentoStore.departamentos;
      }
    }
  } catch (error: any) {
    showError('Erro ao carregar dados');
  }
};

const saveInstituicao = async (data: Partial<Instituicao>) => {
  formLoading.value = true;
  try {
    await instituicaoStore.createInstituicao(data as any);
    showSuccess('Instituição criada com sucesso');
    await loadInstituicoes();
  } catch (error: any) {
    showError(error.message || 'Erro ao salvar instituição');
  } finally {
    formLoading.value = false;
  }
};

const saveEndereco = async (data: Partial<Endereco>) => {
  try {
    await enderecoStore.createEndereco(data as any);
    showSuccess('Endereço criado com sucesso');
    await loadInstituicoes();
  } catch (error: any) {
    showError(error.message || 'Erro ao salvar endereço');
  }
};

const saveDepartamento = async (data: Partial<Departamento>) => {
  try {
    await departamentoStore.createDepartamento(data as any);
    showSuccess('Departamento criado com sucesso');
    await loadInstituicoes();
  } catch (error: any) {
    showError(error.message || 'Erro ao salvar departamento');
  }
};

// Funções de edição e exclusão (placeholders)
const editInstituicao = (instituicao: Instituicao) => console.log('Edit instituicao', instituicao);
const deleteInstituicao = (instituicao: Instituicao) => console.log('Delete instituicao', instituicao);
const editEndereco = (endereco: Endereco) => console.log('Edit endereco', endereco);
const deleteEndereco = (endereco: Endereco) => console.log('Delete endereco', endereco);
const editDepartamento = (departamento: Departamento) => console.log('Edit departamento', departamento);
const deleteDepartamento = (departamento: Departamento) => console.log('Delete departamento', departamento);

</script>

<style scoped>
.cadastro-view {
  display: flex;
  flex-direction: column;
  padding: 20px;
}

.forms-container {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
  gap: 20px;
}

.form-section {
  flex: 1;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #fff;
}

.list-container {
  border: 1px solid #ccc;
  padding: 20px;
  border-radius: 8px;
  background-color: #fff;
}
</style>