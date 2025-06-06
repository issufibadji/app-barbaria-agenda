<template>
<AdminLayout>
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Logs</h1>
      <Link href="/audit-logs/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Log</Link>
    </div>
    <div class="overflow-x-auto bg-white dark:bg-violet-800 rounded shadow">
      <table class="min-w-full text-sm table-auto">
        <thead class="bg-violet-100 dark:bg-violet-700 text-left text-violet-800 dark:text-white">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Usuário</th>
            <th class="px-4 py-3">Ação</th>
            <th class="px-4 py-3">Detalhes</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs.data" :key="log.id" class="border-t border-gray-200 dark:border-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900">
            <td class="px-4 py-2">{{ log.id }}</td>
            <td class="px-4 py-2">{{ log.user?.name || '-' }}</td>
            <td class="px-4 py-2">{{ log.event }}</td>
            <td class="px-4 py-2">{{ log.tags }}</td>
            <td class="px-4 py-2 flex space-x-2">
              <Link :href="`/audit-logs/${log.id}/edit`" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Editar</Link>
              <button @click="deleteLog(log.id)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="p-2">
        <Pagination :links="logs.links" />
      </div>
    </div>
  </div>
</AdminLayout>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  logs: Object
})

function deleteLog(id) {
  if (confirm('Deseja excluir este log?')) {
    router.delete(`/audit-logs/${id}`)
  }
}
</script>
