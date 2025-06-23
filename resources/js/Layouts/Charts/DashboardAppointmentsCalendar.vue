<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { format, addDays, startOfWeek } from 'date-fns'
import { ptBR } from 'date-fns/locale'
import { parseISO } from 'date-fns'

const props = defineProps({
  appointmentsWeek: Object
})

const currentDate = ref(new Date())
const localAppointments = ref({
  '2025-06-23': [
    {
      time: '09:00',
      price: 30.0,
      client: { name: 'João Silva' },
      service: { name: 'Corte Masculino' }
    },
    {
      time: '10:00',
      price: 20.0,
      client: { name: 'Carlos Souza' },
      service: { name: 'Barba Completa' }
    }
  ],
  '2025-06-24': [
    {
      time: '14:30',
      price: 50.0,
      client: { name: 'Pedro Lucas' },
      service: { name: 'Corte + Barba' }
    }
  ],
  '2025-06-26': [
    {
      time: '16:00',
      price: 45.0,
      client: { name: 'Felipe Rocha' },
      service: { name: 'Sobrancelha + Corte' }
    },
    {
      time: '17:00',
      price: 45.0,
      client: { name: 'Marcos Rocha' },
      service: { name: 'Sobrancelha + Corte' }
    }
  ]
})

const selectedDateKey = ref(format(new Date(), 'yyyy-MM-dd'))

const startWeek = computed(() =>
  startOfWeek(currentDate.value, { weekStartsOn: 1 })
)

const daysOfWeek = computed(() => {
  return Array.from({ length: 7 }, (_, i) => {
    const date = addDays(startWeek.value, i)
    const key = format(date, 'yyyy-MM-dd')
    const appointments = localAppointments.value[key] || []
    const total = appointments.length
    const totalValue = appointments.reduce((sum, ag) => sum + parseFloat(ag.price), 0)

    return {
      date,
      key,
      labelDay: format(date, 'EEEE', { locale: ptBR }),
      labelNum: format(date, 'dd'),
      total,
      totalValue,
      isToday: format(date, 'yyyy-MM-dd') === format(new Date(), 'yyyy-MM-dd'),
      isSelected: key === selectedDateKey.value,
    }
  })
})

const selectedAppointments = computed(() => {
  return localAppointments.value[selectedDateKey.value] || []
})

async function fetchAppointments() {
  const startDate = format(startWeek.value, 'yyyy-MM-dd')
  const { data } = await axios.get(route('dashboard.weekData'), {
    params: { startDate }
  })
  localAppointments.value = data.appointmentsWeek
}

async function nextWeek() {
  currentDate.value = addDays(currentDate.value, 7)
  await fetchAppointments()
}

async function prevWeek() {
  currentDate.value = addDays(currentDate.value, -7)
  await fetchAppointments()
}
</script>
<template>
  <!-- Card principal com botão fixado no topo direito -->
  <div class="relative rounded-lg bg-gray-900 text-white p-6 pt-16 shadow-md">
    <!-- Botão fixado acima no canto direito -->
    <div class="absolute top-4 right-4 z-10">
      <button class="py-2 px-4 bg-gradient-to-r from-orange-500 to-orange-700 rounded-full text-white font-semibold shadow-lg flex items-center gap-2">
        <i class="fas fa-lock"></i>
        <span>Novo Agendamento</span>
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>

    <!-- Cabeçalho da agenda -->
    <div class="flex items-center justify-between mb-4">
      <div>
        <p class="text-sm">Olá, Alex</p>
        <p class="text-xs text-gray-400">Você está em sua agenda.</p>
        <p class="text-xs text-gray-300">
          📅 {{ format(startWeek, "dd 'de' MMMM", { locale: ptBR }) }} à
          {{ format(addDays(startWeek, 6), "dd 'de' MMMM yyyy", { locale: ptBR }) }}
        </p>
      </div>

      <div class="flex gap-2">
        <button @click="prevWeek" class="p-2 text-white bg-gray-800 hover:bg-gray-700 rounded">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button @click="nextWeek" class="p-2 text-white bg-gray-800 hover:bg-gray-700 rounded">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Dias da Semana -->
    <div class="flex gap-2 overflow-x-auto pb-2">
      <div
        v-for="day in daysOfWeek"
        :key="day.key"
        @click="selectedDateKey = day.key"
        :class="[ 'flex flex-col items-center justify-center px-3 py-2 rounded-md min-w-[100px] cursor-pointer',
          day.isSelected ? 'bg-orange-600 text-white' : 'bg-gray-800 text-gray-200'
        ]"
      >
        <div class="text-sm font-bold uppercase">{{ day.labelDay }}</div>
        <div class="text-2xl font-black">{{ day.labelNum }}</div>
        <div class="text-xs mt-1">
          <i class="fas fa-coins mr-1"></i> R$ {{ day.totalValue.toFixed(2) }}
        </div>
        <div class="text-xs">
          <i class="fas fa-cut mr-1"></i> {{ day.total }}
        </div>
      </div>
    </div>
    <!-- Agendamentos do dia selecionado -->
    <div v-if="localAppointments[selectedDateKey]?.length" class="mt-6 space-y-4">
    <div
        v-for="(ag, index) in localAppointments[selectedDateKey]"
        :key="index"
        class="bg-gray-800 border border-gray-700 rounded-xl p-4 text-white relative shadow hover:shadow-lg transition"
    >
        <!-- Ícones no topo direito -->
        <div class="absolute top-2 right-2 flex gap-2 text-gray-400">
        <i class="fas fa-bell"></i>
        <i class="fas fa-ellipsis-v"></i>
        </div>

        <div class="flex justify-between items-center">
        <div class="flex flex-col space-y-1">
            <div class="text-sm text-orange-400 font-semibold">
            <i class="fas fa-clock mr-1"></i>{{ ag.time }}
            </div>
            <div class="text-base font-bold flex items-center gap-2">
            <i class="fas fa-user text-gray-400"></i>{{ ag.client.name }}
            </div>
            <div class="text-xs text-gray-400">
            <i class="fas fa-cut text-gray-500 mr-1"></i>{{ ag.service.name }}
            </div>
        </div>
        <div class="text-green-400 font-bold text-lg">
            <i class="fas fa-coins mr-1"></i> R$ {{ parseFloat(ag.price).toFixed(2) }}
        </div>
        </div>
    </div>
    </div>

    <!-- Nenhum agendamento -->
    <div v-else class="text-center text-sm mt-6 text-gray-400">
      Nenhum agendamento
    </div>
  </div>
</template>


