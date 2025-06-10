<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({ addresses: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão Endereços</h1>
        <Link :href="route('addresses.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Endereço</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">CEP</th>
              <th class="px-4 py-2">Rua/Avenida</th>
              <th class="px-4 py-2">Complemento</th>
              <th class="px-4 py-2">Cidade</th>
              <th class="px-4 py-2">UF</th>
              <th class="px-4 py-2">Estabelecimento</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="addr in addresses.data" :key="addr.id" class="border-t">
              <td class="px-4 py-2">{{ addr.id }}</td>
              <td class="px-4 py-2">{{ addr.cep }}</td>
              <td class="px-4 py-2">{{ addr.street }}</td>
              <td class="px-4 py-2">{{ addr.complement }}</td>
              <td class="px-4 py-2">{{ addr.city }}</td>
              <td class="px-4 py-2">{{ addr.uf }}</td>
              <td class="px-4 py-2">{{ addr.establishment?.name || '—' }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('addresses.edit', addr.id)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('addresses.destroy', addr.id)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="addresses.data.length === 0">
              <td colspan="8" class="px-4 py-2 text-center">Nenhum Endereço encontrado.</td>
            </tr>
          </tbody>
        </table>
        <div class="p-2">
          <Pagination :links="addresses.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
