<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  professionals:{
    type:Object,
    default: () => ({ data: [], links: [] })
  }
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Profissionais</h1>
        <Link :href="route('professionals.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Profissional</Link>
      </div>
      <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-sm table-auto">
          <thead class="bg-violet-100 text-left">
            <tr>
              <th class="px-4 py-2">Nome</th>
              <th class="px-4 py-2">Estabelecimento</th>
              <th class="px-4 py-2">Comissão (%)</th>
              <th class="px-4 py-2 text-right">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pro in professionals.data" :key="pro.id" class="border-t">
              <td class="px-4 py-2">{{ pro.user?.name }}</td>
              <td class="px-4 py-2">{{ pro.establishment?.name || '—' }}</td>
              <td class="px-4 py-2">{{ pro.commission }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <Link :href="route('professionals.edit', pro.uuid)" class="text-yellow-600 hover:underline">Editar</Link>
                <Link as="button" method="delete" :href="route('professionals.destroy', pro.uuid)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
              </td>
            </tr>
            <tr v-if="professionals?.data?.length === 0">
              <td colspan="4" class="px-4 py-2 text-center">Nenhum profissional cadastrado.</td>
            </tr>
          </tbody>
        </table>
        <div class="p-2">
          <Pagination :links="professionals.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
