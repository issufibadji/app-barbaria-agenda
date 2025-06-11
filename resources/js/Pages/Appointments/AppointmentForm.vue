<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  appointment: Object,
  services: Object,
  clients: Object,
  mode: String
})

const form = useForm({
  service_id: props.appointment?.service_id || '',
  client_id: props.appointment?.client_id || '',
  scheduled_at: props.appointment?.scheduled_at || '',
  status: props.appointment?.status || 'pendente'
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('appointments.update', props.appointment.id), { _method: 'put' })
  } else {
    form.post(route('appointments.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Agendamento' : 'Cadastrar Agendamento'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">
        {{ props.mode === 'edit' ? 'Editar Agendamento' : 'Cadastrar Agendamento' }}
      </h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-3 gap-4">
          <div>
            <InputLabel for="service_id" value="Serviço" />
            <select id="service_id" v-model="form.service_id" class="input">
              <option value="">Selecione</option>
              <option v-for="(name, id) in services" :key="id" :value="id">{{ name }}</option>
            </select>
            <InputError :message="form.errors.service_id" />
          </div>
          <div>
            <InputLabel for="client_id" value="Cliente" />
            <select id="client_id" v-model="form.client_id" class="input">
              <option value="">Selecione</option>
              <option v-for="(name, id) in clients" :key="id" :value="id">{{ name }}</option>
            </select>
            <InputError :message="form.errors.client_id" />
          </div>
          <div>
            <InputLabel for="scheduled_at" value="Data & Hora" />
            <input id="scheduled_at" type="datetime-local" v-model="form.scheduled_at" class="input" />
            <InputError :message="form.errors.scheduled_at" />
          </div>
        </div>
        <div>
          <InputLabel for="status" value="Status" />
          <select id="status" v-model="form.status" class="input">
            <option value="pendente">Pendente</option>
            <option value="confirmado">Confirmado</option>
            <option value="cancelado">Cancelado</option>
          </select>
          <InputError :message="form.errors.status" />
        </div>
        <div class="flex gap-2">
          <Link :href="route('appointments.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
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
