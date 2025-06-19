<script setup>
import { ref, onMounted } from 'vue'
import { format } from 'date-fns'
import { ptBR } from 'date-fns/locale'

const props = defineProps({
  establishment: Object,
  messages: Object
})

const nomeCliente = ref('')
const etapa = ref(1)
const input = ref('')
const notificacoesAtivadas = ref(false)
const chatMessages = ref([])

const services = ref([
  { id: 1, name: 'Corte & Barba', price: 45.00, duration: '25min' },
  { id: 2, name: 'Corte', price: 30.00, duration: '40min' },
  { id: 3, name: 'Barba', price: 20.00, duration: '15min' }
])

const selectedServices = ref([])
const selectedDate = ref(null)
const selectedTime = ref(null)
const telefone = ref('')


const substituirTags = (texto) => {
  const mock = {
    nome_cliente: nomeCliente.value || 'cliente',
    data_agendamento: selectedDate.value || '20/06/2025',
    hora_agendamento: selectedTime.value || '15:30',
    link: `https://chat.seusistema.com/${props.establishment.manual_chat_link}`,
    nome_estabelecimento: props.establishment.name,
    chat_link: window.location.href
  }
  return texto.replace(/\{([^}]+)\}/g, (_, chave) => mock[chave] || '')
}

onMounted(() => {
  // Saudação clara, sem tags
  const saudacao = props.messages?.confirmacao_agendamento ||
  `Olá, tudo bem?\nSou a assistente virtual do(a) ${props.establishment.name} e cuido do agendamento dos serviços dos profissionais dele(a). Vamos começar?`

  chatMessages.value.push({ from: 'bot', text: saudacao })

  setTimeout(() => {
    chatMessages.value.push({ from: 'bot', text: 'Qual é o seu nome completo?' })
  }, 600)
})

const enviarResposta = () => {
  if (!input.value.trim()) return

  if (etapa.value === 1) {
    nomeCliente.value = input.value.trim().replace(/\b\w/g, l => l.toUpperCase())
    chatMessages.value.push({ from: 'user', text: nomeCliente.value })

    etapa.value = 2

    setTimeout(() => {
     chatMessages.value.push({ from: 'bot', text: `Prazer em conhecê-lo, ${nomeCliente.value}! 😊` })
     chatMessages.value.push({ from: 'bot', text: 'Para receber lembretes do agendamento, ative as notificações abaixo:' })

    }, 300)
  }

  input.value = ''
}

const ativarNotificacoes = () => {
  notificacoesAtivadas.value = true
  chatMessages.value.push({ from: 'bot', text: 'Notificações ativadas com sucesso! ✉️' })
  mostrarServicos()
}

const pularEtapa = () => {
  chatMessages.value.push({ from: 'bot', text: 'Tudo bem! Você pode continuar mesmo sem ativar notificações.' })
  mostrarServicos()
}

const mostrarServicos = () => {
  etapa.value = 3
  chatMessages.value.push({ from: 'bot', text: 'Por favor, selecione o(s) serviço(s) desejado(s):' })
}

const enviarServicoSelecionado = () => {
  if (selectedServices.value.length === 0) return
  const selecionados = services.value.filter(s => selectedServices.value.includes(s.id))
  chatMessages.value.push({ from: 'user', text: selecionados.map(s => s.name).join(', ') })
  chatMessages.value.push({ from: 'bot', text: 'Perfeito! Agora escolha o melhor dia e horário para ser atendido:' })
  etapa.value = 4
}

const dias = Array.from({ length: 5 }, (_, i) => {
  const data = new Date()
  data.setDate(data.getDate() + i)
  return {
    label: format(data, 'EEE', { locale: ptBR }).toUpperCase(),
    date: format(data, 'yyyy-MM-dd'),
    display: format(data, "dd 'de' MMMM", { locale: ptBR })
  }
})

const horarios = ['09:00', '10:30', '13:00', '15:00', '16:30']

const selecionarHorario = () => {
  if (!selectedDate.value || !selectedTime.value) return
  chatMessages.value.push({ from: 'user', text: `Dia ${selectedDate.value} às ${selectedTime.value}` })
  chatMessages.value.push({ from: 'bot', text: 'Que bom, qual seu telefone?' })
  etapa.value = 5
}

const enviarTelefone = () => {
  if (!telefone.value.trim()) return
  chatMessages.value.push({ from: 'user', text: telefone.value.trim() })
  etapa.value = 6

  // Mensagem final
  chatMessages.value.push({ from: 'bot', text: 'Perfeito....' })
  chatMessages.value.push({
    from: 'bot',
    text: `Agendamento realizado: Um(a) ${selectedServices.value.map(id => services.value.find(s => s.id === id)?.name).join(', ')} - com o(a) profissional no(a) ${selectedDate.value} às ${selectedTime.value}.`
  })
  chatMessages.value.push({ from: 'bot', text: 'Muito obrigado, até mais! 🧔✂️' })
}
</script>



<template>
  <div class="min-h-screen bg-gray-900 text-white flex flex-col items-center p-4">
    <div class="w-full max-w-xl bg-gray-800 rounded shadow p-4 flex flex-col space-y-4">

      <!-- Mensagens -->
      <div class="overflow-y-auto max-h-[400px] space-y-2">
        <div v-for="(msg, index) in chatMessages" :key="index" class="w-full">
          <div :class="msg.from === 'user' ? 'text-right' : 'text-left'" class="text-sm">
            <span :class="msg.from === 'user' ? 'bg-gray-500' : 'bg-brown-600'" class="inline-block px-4 py-2 rounded-xl text-white max-w-[80%] whitespace-pre-line">
              {{ substituirTags(msg.text) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Etapa 1: Nome -->
      <div v-if="etapa === 1" class="flex gap-2">
        <input
          v-model="input"
          @keyup.enter="enviarResposta"
          placeholder="Digite seu nome completo..."
          class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 text-white"
        />
        <button @click="enviarResposta" class="bg-brown-600 px-4 py-2 rounded text-white">Enviar</button>
      </div>

      <!-- Etapa 2: Notificações -->
      <div v-if="etapa === 2" class="flex flex-col gap-2">
        <button @click="ativarNotificacoes" class="bg-gray-600 px-4 py-2 rounded text-white">Ativar notificações</button>
        <button @click="pularEtapa" class="bg-gray-700 px-4 py-2 rounded text-white">Pular</button>
      </div>

      <!-- Etapa 3: Seleção de Serviços -->
      <div v-if="etapa === 3" class="space-y-4">
        <p class="text-sm text-gray-400">Selecione os serviços desejados:</p>
        <div class="flex flex-wrap gap-2">
          <label
            v-for="s in services"
            :key="s.id"
            class="bg-gray-700 hover:bg-gray-600 cursor-pointer px-4 py-3 rounded w-full sm:w-auto text-left"
          >
            <input
              type="checkbox"
              class="mr-2 accent-brown-600"
              v-model="selectedServices"
              :value="s.id"
            />
            <div class="font-bold">{{ s.name }}</div>
            <div class="text-sm">R$ {{ s.price.toFixed(2) }} – {{ s.duration }}</div>
          </label>
        </div>
        <button @click="enviarServicoSelecionado" class="bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded">
          Enviar
        </button>
      </div>
      <!-- Etapa 4: Seleção de data e horário -->
    <div v-if="etapa === 4" class="space-y-4">
    <p class="text-sm text-gray-400">Selecione o dia:</p>
    <div class="flex gap-2 overflow-x-auto">
        <button
        v-for="d in dias"
        :key="d.date"
        @click="selectedDate = d.display"
        :class="['px-4 py-2 rounded', selectedDate === d.display ? 'bg-brown-600 text-white' : 'bg-gray-700 text-gray-300']"
        >
        <div class="font-bold">{{ d.label }}</div>
        <div class="text-xs">{{ d.display }}</div>
        </button>
    </div>

    <p class="text-sm text-gray-400">Escolha o horário:</p>
    <div class="flex flex-wrap gap-2">
        <button
        v-for="h in horarios"
        :key="h"
        @click="selectedTime = h"
        :class="['px-3 py-2 rounded', selectedTime === h ? 'bg-brown-600 text-white' : 'bg-gray-700 text-gray-300']"
        >
        {{ h }}
        </button>
    </div>

    <button
        @click="selecionarHorario"
        class="mt-2 bg-brown-600 hover:bg-brown-700 text-white px-4 py-2 rounded"
    >
        Enviar
    </button>
    </div>
    <!-- Etapa 5: Telefone -->
    <div v-if="etapa === 5" class="flex gap-2">
    <input
        v-model="telefone"
        @keyup.enter="enviarTelefone"
        type="tel"
        placeholder="Digite seu telefone..."
        class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 text-white"
    />
    <button @click="enviarTelefone" class="bg-brown-600 px-4 py-2 rounded text-white">Enviar</button>
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
