<template>
  <AdminLayout>
    <Head title="Mensagens Manuais" />
    <div class="max-w-5xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-4 text-brown-800">Mensagens Manuais</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div v-for="(group, type) in groupedMessages" :key="type" class="bg-white shadow rounded p-4">
          <h2 class="text-lg font-semibold mb-2 text-brown-700">{{ messageLabels[type] || type }}</h2>
          <div v-for="msg in group" :key="msg.id" class="mb-4">
            <textarea v-model="form.messages[msg.id]" class="input" rows="3"></textarea>
          </div>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-brown-700 hover:bg-brown-600 text-white px-4 py-2 rounded">Salvar</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  messages: Array,
})

const groupedMessages = computed(() => {
  return props.messages.reduce((acc, msg) => {
    if (!acc[msg.type]) acc[msg.type] = []
    acc[msg.type].push(msg)
    return acc
  }, {})
})

const form = ref({
  messages: Object.fromEntries(props.messages.map(m => [m.id, m.content]))
})

const messageLabels = {
  confirmation: 'Confirmação de Agendamento',
  cancellation: 'Cancelamento de Agendamento',
  post_visit: 'Mensagem Pós Atendimento',
  invite: 'Mensagem de Convite',
}

function submit() {
  router.post(route('messages.bulk-update'), {
    messages: form.value.messages,
  })
}
</script>

<style scoped>
.input {
  @apply w-full rounded border border-gray-300 p-2 focus:outline-none focus:ring focus:ring-brown-400;
}
</style>
