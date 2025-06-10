<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ schedules: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Agendas</h1>
        <Link :href="route('schedules.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Agenda</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Agenda</th>
              <th class="px-4 py-2">Profissional</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in schedules" :key="item.id" class="border-t">
              <td class="px-4 py-2">{{ item.id }}</td>
              <td class="px-4 py-2">{{ item.schedule }}</td>
              <td class="px-4 py-2">{{ item.professional?.user?.name }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('schedules.edit', item.id)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('schedules.destroy', item.id)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="schedules.length === 0">
              <td colspan="4" class="px-4 py-2 text-center">Nenhuma agenda encontrada.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
