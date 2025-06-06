<template>
<AdminLayout>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Criar Log</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block font-medium mb-1">Usuário</label>
        <select v-model="form.user_id" class="w-full border rounded px-3 py-2">
          <option :value="null">Selecione...</option>
          <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block font-medium mb-1">Ação</label>
        <input v-model="form.action" type="text" class="w-full border rounded px-3 py-2" />
        <span class="text-sm text-red-500" v-if="form.errors.action">{{ form.errors.action }}</span>
      </div>
      <div class="mb-4">
        <label class="block font-medium mb-1">Detalhes</label>
        <textarea v-model="form.details" class="w-full border rounded px-3 py-2"></textarea>
      </div>
      <div class="flex justify-end gap-2">
        <Link href="/audit-logs" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Voltar</Link>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
      </div>
    </form>
  </div>
</AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({ users: Array })

const form = useForm({
  user_id: null,
  action: '',
  details: ''
})

function submit() {
  form.post('/audit-logs')
}
</script>
