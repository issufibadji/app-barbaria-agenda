<template>
<AdminLayout>
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Lista de Permissões</h1>
      <Link href="/permissions/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Permissão</Link>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-brown-800 rounded shadow">
      <table class="min-w-full text-sm table-auto">
        <thead class="bg-brown-100 dark:bg-brown-700 text-left text-brown-800 dark:text-white">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Tag</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in permissions" :key="permission.id" class="border-t border-gray-200 dark:border-brown-600 hover:bg-brown-50 dark:hover:bg-brown-900">
            <td class="px-4 py-2">{{ permission.id }}</td>
            <td class="px-4 py-2">{{ permission.name }}</td>
            <td class="px-4 py-2">{{ permission.module || '-' }}</td>
            <td class="px-4 py-2 flex space-x-2">
              <Link :href="`/permissions/${permission.id}/edit`" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Editar</Link>
              <button @click="deletePermission(permission.id)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
 </AdminLayout>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
defineProps({ permissions: Array })

function deletePermission(id) {
  if (confirm('Deseja excluir esta permissão?')) {
    router.delete(`/permissions/${id}`)
  }
}
</script>
