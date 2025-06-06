<template>
<AdminLayout>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Auditorias</h1>
    <div class="overflow-x-auto bg-white dark:bg-violet-800 rounded shadow">
      <table class="min-w-full text-sm table-auto">
        <thead class="bg-violet-100 dark:bg-violet-700 text-left text-violet-800 dark:text-white">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Usuário</th>
            <th class="px-4 py-3">Evento</th>
            <th class="px-4 py-3">Tags</th>
            <th class="px-4 py-3">Data</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="audit in audits.data" :key="audit.id" class="border-t border-gray-200 dark:border-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900">
            <td class="px-4 py-2">{{ audit.id }}</td>
            <td class="px-4 py-2">{{ audit.user?.name || '-' }}</td>
            <td class="px-4 py-2">{{ audit.event }}</td>
            <td class="px-4 py-2">{{ audit.tags }}</td>
            <td class="px-4 py-2">{{ new Date(audit.created_at).toLocaleString() }}</td>
            <td class="px-4 py-2">
            <Link :href="`/audits/${audit.id}`" class="text-blue-600 hover:underline">Visualizar</Link>
            <button
                @click="deleteAudit(audit.id)"
                class="text-red-600 hover:underline"
            >
                Excluir
            </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="p-2">
        <Pagination :links="audits.links" />
      </div>
    </div>
  </div>
</AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  audits: Object
})

function deleteAudit(id) {
  if (confirm('Deseja excluir este log de auditoria?')) {
    router.delete(`/audits/${id}`, {
      onSuccess: () => {
        // você pode adicionar um toast, se quiser
      }
    })
  }
}
</script>
