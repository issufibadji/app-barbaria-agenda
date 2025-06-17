<script setup>
import { onMounted, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  establishment: Object
})

const messages = ref([
  { from: 'system', text: `Olá, seja bem-vindo à ${props.establishment.name}! 😊` },
  { from: 'system', text: 'Por qual serviço você está procurando?' }
])

const services = ref([])
const selectedServices = ref([])

const loadServices = async () => {
  const response = await fetch(`/api/public/${props.establishment.uuid}/services`)
  services.value = await response.json()
}

const send = () => {
  if (selectedServices.value.length === 0) return
  const selected = services.value.filter(s => selectedServices.value.includes(s.id))
  messages.value.push({
    from: 'user',
    text: selected.map(s => s.name).join(', ')
  })
  // resposta simulada
  messages.value.push({ from: 'system', text: 'Obrigado! Vamos continuar com o agendamento...' })
  selectedServices.value = []
}

onMounted(loadServices)
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center p-4">
    <div class="w-full max-w-2xl bg-gray-800 rounded shadow p-4 flex flex-col space-y-4">
      <div class="overflow-y-auto max-h-[400px] space-y-2">
        <div v-for="(msg, index) in messages" :key="index" class="w-full">
          <div
            :class="msg.from === 'user' ? 'text-right' : 'text-left'"
            class="text-sm"
          >
            <span
              :class="msg.from === 'user' ? 'bg-blue-600' : 'bg-brown-600'"
              class="inline-block px-3 py-2 rounded text-white"
            >
              {{ msg.text }}
            </span>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-700 pt-4">
        <p class="mb-2 text-sm text-gray-400">Selecione os serviços:</p>
        <div class="flex flex-wrap gap-2 mb-4">
          <label v-for="s in services" :key="s.id" class="bg-gray-700 px-3 py-1 rounded cursor-pointer">
            <input
              type="checkbox"
              class="mr-1 accent-brown-600"
              v-model="selectedServices"
              :value="s.id"
            />
            {{ s.name }} - R$ {{ s.price }}
          </label>
        </div>

        <button
          @click="send"
          class="bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded"
        >
          Enviar
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-thumb {
  background-color: #6d4c41;
  border-radius: 3px;
}
</style>
