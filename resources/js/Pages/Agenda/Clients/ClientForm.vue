<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Head } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  client: Object,
  users: Object,
  mode: String
})

const form = useForm({
  user_id: props.client?.user_id || '',
  gender: props.client?.gender || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.put(route('agendaai.clients.update', props.client.id))
  } else {
    form.post(route('agendaai.clients.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Cliente' : 'Cadastrar Cliente'" />
    <div class="max-w-3xl mx-auto py-8 px-4">
      <h1 class="text-2xl font-bold text-violet-900 dark:text-white mb-6">
        {{ props.mode === 'edit' ? 'Editar Cliente' : 'Cadastrar Cliente' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="user_id" class="block text-sm font-medium text-violet-700">Usuário</label>
          <select id="user_id" v-model="form.user_id" class="input">
            <option value="">-- Selecione o Usuário --</option>
            <option v-for="(name, id) in users" :key="id" :value="id">{{ name }}</option>
          </select>
          <InputError :message="form.errors.user_id" class="mt-1" />
        </div>

        <div>
          <label for="gender" class="block text-sm font-medium text-violet-700">Gênero</label>
          <input id="gender" type="text" v-model="form.gender" class="input" />
          <InputError :message="form.errors.gender" class="mt-1" />
        </div>

        <div class="flex justify-end">
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-violet-700 text-white rounded hover:bg-violet-600" :disabled="form.processing">
            {{ props.mode === 'edit' ? 'Atualizar' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500;
}
</style>
