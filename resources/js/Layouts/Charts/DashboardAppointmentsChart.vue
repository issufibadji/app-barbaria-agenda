<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const props = defineProps({
  data: Array
})

const chartData = {
  labels: props.data.map(d => d.day),
  datasets: [{
    label: 'Agendamentos',
    backgroundColor: '#8B5CF6',
    data: props.data.map(d => d.count)
  }]
}

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
    title: {
      display: true,
      text: 'Agendamentos por Dia da Semana'
    }
  }
}
</script>

<template>
  <Bar :data="chartData" :options="chartOptions" />
</template>
