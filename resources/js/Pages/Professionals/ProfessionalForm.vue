<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  professional: Object,
  mode: String,
  users: Object,
  establishments: Object
})

const form = useForm({
  user_id: props.professional?.user_id || '',
  commission: props.professional?.commission || '',
  establishment_id: props.professional?.establishment_id || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('professionals.update', props.professional.uuid), { _method: 'put' })
  } else {
    form.post(route('professionals.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Profissional' : 'Cadastrar Profissional'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">
        {{ props.mode === 'edit' ? 'Editar Profissional' : 'Cadastrar Profissional' }}
      </h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <InputLabel for="user_id" value="Usuário" />
          <select id="user_id" v-model="form.user_id" class="input">
            <option value="">Selecione</option>
            <option v-for="(name, id) in users" :key="id" :value="id">{{ name }}</option>
          </select>
          <InputError :message="form.errors.user_id" />
        </div>
        <div>
          <InputLabel for="commission" value="Comissão (%)" />
          <input id="commission" v-model="form.commission" type="number" step="0.01" class="input" />
          <InputError :message="form.errors.commission" />
        </div>
        <div>
          <InputLabel for="establishment_id" value="Estabelecimento" />
          <select id="establishment_id" v-model="form.establishment_id" class="input">
            <option value="">Selecione</option>
            <option v-for="(name, id) in establishments" :key="id" :value="id">{{ name }}</option>
          </select>
          <InputError :message="form.errors.establishment_id" />
        </div>
        <div class="flex gap-2">
          <Link :href="route('professionals.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
          <button type="submit" class="px-4 py-2 bg-brown-700 text-white rounded hover:bg-brown-600" :disabled="form.processing">
            {{ props.mode === 'edit' ? 'Atualizar' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brown-500 focus:ring-brown-500;
}
</style>
