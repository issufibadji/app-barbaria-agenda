<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  messages: Object
})

const form = ref({
  messages: {
    ...props.messages
  }
})

function salvar() {
  router.post(route('messages.settings.update'), form.value)
}
</script>

<template>
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Mensagens Manuais</h1>
    <p class="mb-4 text-sm text-gray-600">
      Use os campos abaixo para personalizar os textos enviados manualmente aos clientes. Você pode utilizar tags dinâmicas como <code>{nome_cliente}</code>, <code>{data_agendamento}</code>, <code>{hora_agendamento}</code>, <code>{link}</code>, <code>{nome_estabelecimento}</code> e <code>{chat_link}</code>.
    </p>

    <div v-for="(message, type) in form.messages" :key="type" class="mb-6">
      <label class="block font-bold capitalize mb-2">{{ type.replace(/_/g, ' ') }}</label>
      <textarea v-model="form.messages[type]" rows="4" class="w-full p-2 border rounded"></textarea>
    </div>

    <button @click="salvar" class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700">
      Salvar
    </button>
  </div>
</template>
