<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ reports: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-6xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Modelos de Relatórios</h1>
        <Link :href="route('relatorios.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">Novo Relatório</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Nome</th>
              <th class="px-4 py-2">Modo Abertura</th>
              <th class="px-4 py-2">Atualizado em</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="r in reports" :key="r.uuid" class="border-t">
              <td class="px-4 py-2">{{ r.uuid }}</td>
              <td class="px-4 py-2">{{ r.name }}</td>
              <td class="px-4 py-2">{{ r.open_mode }}</td>
              <td class="px-4 py-2">{{ r.updated_at }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('relatorios.renderReport', r.uuid)" class="text-blue-600 hover:underline" target="_blank">Visualizar</Link>
                <Link :href="route('relatorios.edit', r.uuid)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('relatorios.destroy', r.uuid)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="reports.length === 0">
              <td colspan="5" class="px-4 py-2 text-center">Nenhum relatório cadastrado.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
