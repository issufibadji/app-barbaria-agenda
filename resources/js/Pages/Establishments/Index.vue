<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  establishments:{
    type:Object,
    default: () => ({ data: [], links: [] })
  }
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-brown-800">Gestão de Estabelecimentos</h1>
        <Link :href="route('establishments.create')" class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700">+ Estabelecimento</Link>
      </div>
      <div class="grid gap-4 md:grid-cols-3">
        <div v-for="est in establishments.data" :key="est.uuid" class="bg-white shadow rounded overflow-hidden flex flex-col">
          <img :src="est.image ? '/storage/' + est.image : '/storage/images/servico-default.jpg'" class="h-48 w-full object-cover" />
          <div class="p-4 flex-1 flex flex-col">
            <h2 class="font-semibold mb-1">{{ est.name }}</h2>
            <p class="text-sm text-gray-600 flex-1">{{ est.descrition }}</p>
            <div class="mt-4 space-x-2">
              <a :href="est.link" target="_blank" class="text-blue-600 hover:underline">Visitar</a>
              <Link :href="route('establishments.edit', est.uuid)" class="text-yellow-600 hover:underline">Editar</Link>
              <Link as="button" method="delete" :href="route('establishments.destroy', est.uuid)" class="text-red-600 hover:underline" preserve-scroll>Excluir</Link>
            </div>
          </div>
        </div>
        <div v-if="establishments?.data?.length === 0" class="col-span-full text-center text-gray-500">Nenhum estabelecimento cadastrado.</div>
      </div>
      <div class="mt-4">
        <Pagination :links="establishments.links" />
      </div>
    </div>
  </AdminLayout>
</template>
