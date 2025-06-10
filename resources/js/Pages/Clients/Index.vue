<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Clientes</h1>
        <Link :href="route('clients.create')" class="btn-primary">
          Novo Cliente
        </Link>
      </div>

      <div class="overflow-x-auto bg-white dark:bg-violet-800 rounded shadow">
        <table class="min-w-full text-sm table-auto">
          <thead class="bg-violet-100 dark:bg-violet-700 text-left text-violet-800 dark:text-white">
            <tr>
              <th class="px-4 py-3">UUID</th>
              <th class="px-4 py-3">Usuário</th>
              <th class="px-4 py-3">Gênero</th>
              <th class="px-4 py-3">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="client in clients.data"
              :key="client.uuid"
              class="border-t hover:bg-violet-50 dark:hover:bg-violet-900"
            >
              <td class="px-4 py-2">{{ client.uuid }}</td>
              <td class="px-4 py-2">{{ client.user?.name || '-' }}</td>
              <td class="px-4 py-2">{{ client.gender }}</td>
              <td class="px-4 py-2 space-x-2">
                <Link :href="route('clients.edit', { client: client.uuid })" class="text-blue-600 hover:underline">
                  Editar
                </Link>
                <button
                  @click="deleteClient(client.uuid)"
                  class="text-red-600 hover:underline"
                >
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="clients?.data?.length === 0" class="col-span-full text-center text-gray-500">Nenhum estabelecimento cadastrado.</div>
        <div class="p-2">
          <Pagination :links="clients.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  clients:{
    type:Object,
    default: () => ({ data: [], links: [] })
  }
})
function deleteClient(id) {
  if (confirm('Deseja excluir este cliente?')) {
    router.delete(route('clients.destroy', { client: id }))
  }
}
</script>
