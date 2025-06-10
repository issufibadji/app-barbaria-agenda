<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({ services: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Serviços</h1>
        <Link :href="route('agendaai.services.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Serviço</Link>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="service in services.data" :key="service.uuid" class="bg-white rounded shadow overflow-hidden">
          <img :src="service.image ? '/storage/' + service.image : '/storage/images/servico-default.jpg'" class="h-48 w-full object-cover" alt="Imagem do serviço" />
          <div class="p-4 space-y-2">
            <h2 class="font-semibold">{{ service.name }}</h2>
            <p class="text-sm text-gray-600">{{ service.descrition?.slice(0,120) }}</p>
            <p class="text-sm">Duração: {{ service.duration_min }} min</p>
            <p class="text-sm font-medium">Valor: R$ {{ Number(service.price).toFixed(2).replace('.', ',') }}</p>
            <div class="flex gap-2 mt-2">
              <Link :href="route('agendaai.services.edit', service.uuid)" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</Link>
              <Link as="button" method="delete" :href="route('agendaai.services.destroy', service.uuid)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" preserve-scroll>Excluir</Link>
            </div>
          </div>
        </div>
        <p v-if="services.data.length === 0" class="text-center col-span-full">Nenhum serviço cadastrado.</p>
      </div>
      <div class="mt-4">
        <Pagination :links="services.links" />
      </div>
    </div>
  </AdminLayout>
</template>
