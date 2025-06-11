<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({ appointments: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-brown-800">Gestão de Agendamentos</h1>
        <Link :href="route('appointments.create')" class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700">+ Agendamento</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-brown-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Serviço</th>
              <th class="px-4 py-2">Cliente</th>
              <th class="px-4 py-2">Data & Hora</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="app in appointments.data" :key="app.id" class="border-t">
              <td class="px-4 py-2">{{ app.id }}</td>
              <td class="px-4 py-2">{{ app.service?.name || '—' }}</td>
              <td class="px-4 py-2">{{ app.client?.user?.name || '—' }}</td>
              <td class="px-4 py-2">{{ app.scheduled_at }}</td>
              <td class="px-4 py-2">{{ app.status }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('appointments.edit', app.id)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('appointments.destroy', app.id)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="appointments.data.length === 0">
              <td colspan="6" class="px-4 py-2 text-center">Nenhum Agendamento encontrado.</td>
            </tr>
          </tbody>
        </table>
        <div class="p-2">
          <Pagination :links="appointments.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
