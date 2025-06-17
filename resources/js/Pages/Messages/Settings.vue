<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  messages: Array,
})

const form = useForm({
  messages: Object.fromEntries(props.messages.map(m => [m.type, m.message]))
})

const labels = {
  confirmacao_agendamento: 'Confirmação de Agendamento',
  cancelamento_agendamento: 'Cancelamento de Agendamento',
  lembrete_agendamento: 'Lembrete de Agendamento',
  agradecimento: 'Mensagem de Agradecimento',
  remarketing: 'Mensagem de Remarketing',
}

const page = usePage()
const flashSuccess = computed(() => page.props.flash?.success)
</script>

<template>
  <AdminLayout>
    <div class="max-w-5xl mx-auto py-10 px-4">
      <h1 class="text-2xl font-bold mb-4">📩 Mensagens Manuais</h1>
      <p class="text-sm mb-6 text-gray-700">
        Use as tags:
        <code class="bg-gray-100 px-1 rounded">{nome_cliente}</code>,
        <code class="bg-gray-100 px-1 rounded">{data_agendamento}</code>,
        <code class="bg-gray-100 px-1 rounded">{hora_agendamento}</code>,
        <code class="bg-gray-100 px-1 rounded">{link}</code>,
        <code class="bg-gray-100 px-1 rounded">{nome_estabelecimento}</code>,
        <code class="bg-gray-100 px-1 rounded">{chat_link}</code>
      </p>

      <div v-if="flashSuccess" class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
        ✅ {{ flashSuccess }}
      </div>

      <div v-for="(value, key) in form.messages" :key="key" class="mb-6">
        <div class="mb-1 font-semibold text-gray-800">
          {{ labels[key] ?? key.replaceAll('_', ' ').toUpperCase() }}
        </div>
        <textarea
          v-model="form.messages[key]"
          rows="4"
          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-brown-300"
        ></textarea>
      </div>

      <button
        @click="form.post(route('messages.settings.update'))"
        class="bg-[#6d4c41] text-white px-5 py-2 rounded hover:bg-[#5d4037]"
      >
        Salvar
      </button>
    </div>
  </AdminLayout>
</template>
