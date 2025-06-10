<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
const props = defineProps({ phones: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Telefones</h1>
        <Link :href="route('phones.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Telefone</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">DDD</th>
              <th class="px-4 py-2">DDI</th>
              <th class="px-4 py-2">Telefone</th>
              <th class="px-4 py-2">Profissional</th>
              <th class="px-4 py-2">Estabelecimento</th>
              <th class="px-4 py-2">Criado em</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="phone in phones.data" :key="phone.id" class="border-t">
              <td class="px-4 py-2">{{ phone.id }}</td>
              <td class="px-4 py-2">{{ phone.ddd }}</td>
              <td class="px-4 py-2">{{ phone.ddi }}</td>
              <td class="px-4 py-2">{{ phone.phone }}</td>
              <td class="px-4 py-2">{{ phone.professional?.user?.name || '—' }}</td>
              <td class="px-4 py-2">{{ phone.establishment?.name || '—' }}</td>
              <td class="px-4 py-2">{{ phone.created_at }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('phones.edit', phone.id)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('phones.destroy', phone.id)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="phones.data.length === 0">
              <td colspan="8" class="px-4 py-2 text-center">Nenhum telefone cadastrado.</td>
            </tr>
          </tbody>
        </table>
        <div class="p-2">
          <Pagination :links="phones.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
