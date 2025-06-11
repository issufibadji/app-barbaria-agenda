<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  message: Object,
  establishments: Object,
  mode: String
})

const form = useForm({
  type: props.message?.type || '',
  message: props.message?.message || '',
  establishment_id: props.message?.establishment_id || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('messages.update', props.message.id), { _method: 'put' })
  } else {
    form.post(route('messages.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Mensagem' : 'Cadastrar Mensagem'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">{{ props.mode === 'edit' ? 'Editar Mensagem' : 'Cadastrar Mensagem' }}</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-6 gap-4">
          <div class="col-span-2">
            <InputLabel for="type" value="Tipo" />
            <input id="type" v-model="form.type" type="text" class="input" />
            <InputError :message="form.errors.type" />
          </div>
          <div class="col-span-4">
            <InputLabel for="establishment_id" value="Estabelecimento" />
            <select id="establishment_id" v-model="form.establishment_id" class="input">
              <option value="">Selecione</option>
              <option v-for="(name, id) in establishments" :key="id" :value="id">{{ name }}</option>
            </select>
            <InputError :message="form.errors.establishment_id" />
          </div>
          <div class="col-span-6">
            <InputLabel for="message" value="Mensagem" />
            <textarea id="message" v-model="form.message" rows="4" class="input"></textarea>
            <InputError :message="form.errors.message" />
          </div>
        </div>
        <div class="flex gap-2">
          <Link :href="route('messages.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
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
