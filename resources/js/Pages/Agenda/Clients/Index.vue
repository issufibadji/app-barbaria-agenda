<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  clients: Object
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Clientes</h1>
        <Link :href="route('agendaai.clients.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          + Cliente
        </Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Usuário</th>
              <th class="px-4 py-2">Gênero</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients.data" :key="client.id" class="border-t">
              <td class="px-4 py-2">{{ client.id }}</td>
              <td class="px-4 py-2">{{ client.user.name }}</td>
              <td class="px-4 py-2">{{ client.gender || '—' }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('agendaai.clients.edit', client.id)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('agendaai.clients.destroy', client.id)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="clients.data.length === 0">
              <td colspan="4" class="px-4 py-2 text-center">Nenhum cliente cadastrado.</td>
            </tr>
          </tbody>
        </table>
        <div class="p-2">
          <Pagination :links="clients.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
