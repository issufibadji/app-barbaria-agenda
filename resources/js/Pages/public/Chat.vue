<script setup>
import { ref, onMounted, computed } from 'vue'

const props = defineProps({
  establishment: Object,
  messages: Object
})

const nomeCliente = ref('')
const etapa = ref(1)
const input = ref('')
const notificacoesAtivadas = ref(false)

const chatMessages = ref([])

const substituirTags = (texto) => {
  const mock = {
    nome_cliente: nomeCliente.value || 'cliente',
    data_agendamento: '20/06/2025',
    hora_agendamento: '15:30',
    link: `https://chat.seusistema.com/${props.establishment.manual_chat_link}`,
    nome_estabelecimento: props.establishment.name,
    chat_link: window.location.href
  }
  return texto.replace(/\{([^}]+)\}/g, (_, chave) => mock[chave] || '')
}

const enviarResposta = () => {
  if (!input.value.trim()) return

  if (etapa.value === 1) {
    nomeCliente.value = input.value.trim()
    chatMessages.value.push({ from: 'user', text: nomeCliente.value })
    etapa.value = 2
    setTimeout(() => {
      chatMessages.value.push({ from: 'bot', text: `Como vai, ${nomeCliente.value}? Tudo bem?` })
      chatMessages.value.push({ from: 'bot', text: 'Para que possamos lembrá-lo de seu agendamento, ative suas notificações clicando abaixo:' })
    }, 300)
  }

  input.value = ''
}

const ativarNotificacoes = () => {
  notificacoesAtivadas.value = true
  chatMessages.value.push({ from: 'bot', text: 'Notificações ativadas com sucesso! ✉️' })
  etapa.value = 3
}

const pularEtapa = () => {
  chatMessages.value.push({ from: 'bot', text: 'Ok! Sem problemas, você ainda pode continuar o agendamento.' })
  etapa.value = 3
}

onMounted(() => {
  chatMessages.value.push({ from: 'bot', text: `Olá, tudo bem? Sou a assistente virtual do(a) ${props.establishment.name} e cuido do agendamento dos serviços dos profissionais dele(a), ok?` })
  setTimeout(() => {
    chatMessages.value.push({ from: 'bot', text: 'Qual o seu nome? Escreva seu nome e sobrenome, por favor.' })
  }, 600)
})
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center p-4">
    <div class="w-full max-w-xl bg-gray-800 rounded shadow p-4 flex flex-col space-y-4">

      <div class="overflow-y-auto max-h-[400px] space-y-2">
        <div v-for="(msg, index) in chatMessages" :key="index" class="w-full">
          <div :class="msg.from === 'user' ? 'text-right' : 'text-left'" class="text-sm">
            <span :class="msg.from === 'user' ? 'bg-gray-500' : 'bg-brown-600'" class="inline-block px-4 py-2 rounded-xl text-white max-w-[80%]">
              {{ substituirTags(msg.text) }}
            </span>
          </div>
        </div>
      </div>

      <div v-if="etapa === 1" class="flex gap-2">
        <input
          v-model="input"
          @keyup.enter="enviarResposta"
          placeholder="Digite seu nome completo..."
          class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 text-white"
        />
        <button @click="enviarResposta" class="bg-brown-600 px-4 py-2 rounded text-white">Enviar</button>
      </div>

      <div v-if="etapa === 2" class="flex flex-col gap-2">
        <button @click="ativarNotificacoes" class="bg-gray-600 px-4 py-2 rounded text-white">Ativar notificações</button>
        <button @click="pularEtapa" class="bg-gray-700 px-4 py-2 rounded text-white">Pular</button>
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
