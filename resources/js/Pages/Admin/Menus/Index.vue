<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Gestão de Menus</h1>
        <Link :href="route('menus.create')" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
          + Novo Menu
        </Link>
      </div>

      <div class="overflow-x-auto bg-white dark:bg-brown-800 rounded shadow">
        <table class="min-w-full text-sm table-auto">
          <thead class="bg-brown-100 dark:bg-brown-700 text-left text-brown-800 dark:text-white">
            <tr>
              <th class="px-4 py-3">Descrição</th>
              <th class="px-4 py-3">Nível</th>
              <th class="px-4 py-3">Rota</th>
              <th class="px-4 py-3">Grupo</th>
              <th class="px-4 py-3">Ordem</th>
              <th class="px-4 py-3">Ativo</th>
              <th class="px-4 py-3">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="menu in menus.data"
              :key="menu.id"
              class="border-t border-gray-200 dark:border-brown-600 hover:bg-brown-50 dark:hover:bg-brown-900"
            >
              <td class="px-4 py-2">{{ menu.description }}</td>
              <td class="px-4 py-2">{{ menu.level }}</td>
              <td class="px-4 py-2">{{ menu.route }}</td>
              <td class="px-4 py-2">{{ menu.group || '-' }}</td>
              <td class="px-4 py-2">{{ menu.order }}</td>
              <td class="px-4 py-2">
                <span :class="menu.active ? 'text-green-600' : 'text-red-600'">
                  {{ menu.active ? 'Sim' : 'Não' }}
                </span>
              </td>
              <td class="px-4 py-2 flex space-x-2">
                <Link
                  :href="route('menus.edit', menu.id)"
                  class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                >
                  Editar
                </Link>
                <button
                  @click="deleteMenu(menu.id)"
                  class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                >
                  Excluir
                </button>
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

defineProps({
  menus: Object
})

function deleteMenu(id) {
  if (confirm('Deseja excluir este menu?')) {
    router.delete(route('menus.destroy', id))
  }
}
</script>
