<script setup>
import { format, addDays, startOfWeek, isToday } from 'date-fns'
import { ptBR } from 'date-fns/locale'

const props = defineProps({
  appointmentsWeek: {
    type: Object,
    default: () => ({})
  }
})

// Começa na segunda-feira (startOfWeek padrão é domingo, então usamos { weekStartsOn: 1 })
const monday = startOfWeek(new Date(), { weekStartsOn: 1 })

const daysOfWeek = Array.from({ length: 7 }, (_, i) => {
  const date = addDays(monday, i)
  return {
    date,
    label: format(date, "eeee dd", { locale: ptBR }),
    key: format(date, 'yyyy-MM-dd'),
    isToday: isToday(date),
  }
})
</script>

<template>
  <div class="mt-6">
    <h2 class="text-lg font-semibold mb-2 text-brown-800">Agenda da Semana</h2>

    <div class="grid grid-cols-7 gap-2 text-sm">
      <div
        v-for="(day, i) in daysOfWeek"
        :key="i"
        :class="[
          'p-2 rounded min-h-[130px] shadow-sm transition',
          day.isToday ? 'bg-yellow-100 border border-yellow-300' : 'bg-gray-100'
        ]"
      >
        <h3 class="font-semibold text-center mb-1 text-brown-800 capitalize">
          {{ day.label }}
        </h3>

        <template v-if="appointmentsWeek[day.key] && appointmentsWeek[day.key].length">
          <div
            v-for="(ag, index) in appointmentsWeek[day.key]"
            :key="index"
            class="bg-white p-1 mt-1 rounded shadow text-xs border border-gray-200"
          >
            <p class="text-brown-700 font-medium">
              <strong>{{ ag.time }}</strong> - {{ ag.client_name }}
            </p>
            <p class="text-gray-500">{{ ag.service_name }} - R$ {{ parseFloat(ag.price).toFixed(2) }}</p>
          </div>
        </template>

        <template v-else>
          <p class="text-gray-400 text-xs text-center mt-4">Nenhum agendamento</p>
        </template>
      </div>
    </div>
  </div>
</template>
