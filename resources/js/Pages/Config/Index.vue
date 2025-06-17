<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Configura\u00e7\u00f5es</h1>
        <Link :href="route('config.create')" class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700">+ Nova Configura\u00e7\u00e3o</Link>
      </div>
      <div class="overflow-x-auto bg-white dark:bg-brown-800 rounded shadow">
        <table class="min-w-full text-sm table-auto">
          <thead class="bg-brown-100 dark:bg-brown-700 text-left text-brown-800 dark:text-white">
            <tr>
              <th class="px-4 py-3">Chave</th>
              <th class="px-4 py-3">Valor</th>
              <th class="px-4 py-3">A\u00e7\u00f5es</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="config in configs" :key="config.id" class="border-t hover:bg-brown-50 dark:hover:bg-brown-900">
              <td class="px-4 py-2">{{ config.key }}</td>
              <td class="px-4 py-2">{{ config.value }}</td>
              <td class="px-4 py-2 space-x-2">
                <Link :href="route('config.edit', config.id)" class="text-blue-600 hover:underline">Editar</Link>
                <button @click="deleteConfig(config.id)" class="text-red-600 hover:underline">Excluir</button>
              </td>
            </tr>
            <tr v-if="configs.length === 0">
              <td colspan="3" class="px-4 py-2 text-center">Nenhuma configura\u00e7\u00e3o encontrada.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  configs: {
    type: Array,
    default: () => []
  }
})

function deleteConfig(id) {
  if (confirm('Deseja excluir esta configura\u00e7\u00e3o?')) {
    router.delete(route('config.destroy', id))
  }
}
</script>
