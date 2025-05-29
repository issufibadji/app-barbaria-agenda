<template>
<AdminLayout>
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Lista de Papéis</h1>
      <Link href="/roles/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Papel</Link>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-violet-800 rounded shadow">
      <table class="min-w-full text-sm table-auto">
        <thead class="bg-violet-100 dark:bg-violet-700 text-left text-violet-800 dark:text-white">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles" :key="role.id" class="border-t border-gray-200 dark:border-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900">
            <td class="px-4 py-2">{{ role.id }}</td>
            <td class="px-4 py-2">{{ role.name }}</td>
            <td class="px-4 py-2 flex space-x-2">
              <Link :href="`/roles/${role.id}/edit`" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Editar</Link>
              <button @click="deleteRole(role.id)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Excluir</button>
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
defineProps({ roles: Array })

function deleteRole(id) {
  if (confirm('Deseja excluir este papel?')) {
    router.delete(`/roles/${id}`)
  }
}
</script>
