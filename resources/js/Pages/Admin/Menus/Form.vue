<template>
  <AdminLayout>
    <div class="max-w-5xl mx-auto px-6 py-8 bg-white dark:bg-violet-900 rounded shadow">
      <h1 class="text-2xl font-bold mb-6 text-violet-700 dark:text-white">Criar Novo Menu</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Descrição</label>
            <input v-model="form.description" class="input" type="text" required />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Ícone</label>
            <input v-model="form.icon" class="input" type="text" placeholder="Ex: mdi-home" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Estilo CSS</label>
            <input v-model="form.style" class="input" type="text" placeholder="Ex: text-red-500" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Menu Pai</label>
            <select v-model="form.parent_id" class="input">
              <option :value="null">- Nenhum -</option>
              <option v-for="item in parents" :key="item.id" :value="item.id">
                {{ item.description }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Nível</label>
            <input v-model.number="form.level" class="input" type="number" min="0" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Rota</label>
            <input v-model="form.route" class="input" type="text" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Permissão (ACL)</label>
            <input v-model="form.acl" class="input" type="text" placeholder="Ex: users.index" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Ordem</label>
            <input v-model.number="form.order" class="input" type="number" min="0" required />
          </div>

          <div>
            <label class="block text-sm font-semibold text-violet-700 dark:text-white">Ativo</label>
            <select v-model="form.active" class="input">
              <option :value="true">Sim</option>
              <option :value="false">Não</option>
            </select>
          </div>

        <div>
        <label class="block text-sm font-medium">Grupo</label>
        <select v-model="form.group" class="input">
            <option value="">Selecione</option>
            <option value="operacional">Operacional</option>
            <option value="gestores">Gestores</option>
            <option value="admin">Administração</option>
        </select>
        </div>

        </div>

        <div class="flex justify-end">
          <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-semibold px-6 py-2 rounded shadow">
            <i class="fas fa-save mr-2"></i>Salvar
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { defineProps } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  menu: Object,
  parents: Array,
  submitUrl: String,
  method: String
})

const form = useForm({
  description: props.menu?.description || '',
  icon: props.menu?.icon || '',
  style: props.menu?.style || '',
  parent_id: props.menu?.parent_id ?? null,
  level: props.menu?.level || 0,
  route: props.menu?.route || '',
  acl: props.menu?.acl || '',
  order: props.menu?.order || 0,
  active: props.menu?.active ?? true,
   group: props.menu?.group || '',
})

function submit() {
  if (props.method === 'post') {
    form.post(props.submitUrl)
  } else {
    form.put(props.submitUrl)
  }
}
</script>

<style scoped>
.input {
  @apply w-full border-gray-300 dark:border-violet-700 dark:bg-violet-800 dark:text-white rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500;
}
</style>
