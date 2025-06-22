<script setup>
import { format, addDays, startOfWeek, isToday } from 'date-fns'
import { ptBR } from 'date-fns/locale'

const props = defineProps({
  appointmentsWeek: {
    type: Object,
    default: () => ({})
  }
})

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
    <div class="flex items-center gap-2 mb-4">
      <i class="fas fa-calendar-check text-brown-600 text-xl"></i>
      <h2 class="text-lg font-semibold text-brown-800">Agenda da Semana</h2>
    </div>

       <div class="grid grid-cols-7 gap-2 text-sm">
      <div
        v-for="(day, i) in daysOfWeek"
        :key="i"
        :class="[
            'p-2 rounded min-h-[130px] shadow-sm transition',
            day.isToday ? 'bg-yellow-100 border border-yellow-300' : 'bg-gray-100'
          ]"
      >
        <h3 class="text-sm font-semibold text-brown-800 capitalize mb-2 text-center">
          {{ day.label }}
        </h3>

        <div v-if="appointmentsWeek[day.key]?.length" class="flex flex-col gap-2">
          <div
            v-for="(ag, index) in appointmentsWeek[day.key]"
            :key="index"
            class="bg-brown-50 border border-brown-200 rounded p-2 text-sm"
          >
            <div class="flex justify-between items-center">
              <span class="text-brown-700 font-semibold">{{ ag.time }}</span>
              <span class="text-green-600 font-medium">R$ {{ parseFloat(ag.price).toFixed(2) }}</span>
            </div>
            <p class="text-brown-900 text-sm">{{ ag.client.name }}</p>
            <p class="text-gray-600 text-xs">{{ ag.service.name }}</p>
          </div>
        </div>

        <p v-else class="text-xs text-center text-gray-400 mt-4">Nenhum agendamento</p>
      </div>
    </div>
  </div>
</template>
