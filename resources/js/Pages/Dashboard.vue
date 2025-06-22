<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import AdminDashboardCards from '@/Layouts/AdminDashboardCards.vue'
import DashboardAppointmentsChart from '@/Layouts/Charts/DashboardAppointmentsChart.vue'

const establishment = usePage().props.establishment
const weeklyAppointments = usePage().props.weeklyAppointments
</script>

<template>
  <Head title="Dashboard" />
<AdminLayout>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

        <h1 class="text-2xl font-semibold text-brown-900 dark:text-white mb-4">Dashboard</h1>

        <!-- ALERTA DE ESTABELECIMENTO INCOMPLETO -->
        <div v-if="!establishment.address || !establishment.phone" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md">
          <p class="font-semibold">Estabelecimento incompleto:</p>
          <ul class="ml-4 list-disc">
            <li v-if="!establishment.address">Endereço não preenchido.</li>
            <li v-if="!establishment.phone">Telefone não cadastrado.</li>
          </ul>
        </div>

        <AdminDashboardCards :establishment="establishment" />
        <DashboardAppointmentsChart :data="weeklyAppointments" />

      </div>
    </div>
  </AdminLayout>
</template>
