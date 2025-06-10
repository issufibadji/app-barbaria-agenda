<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ plans: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Planos</h1>
        <Link :href="route('plans.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Plano</Link>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="plan in plans" :key="plan.id" class="bg-white rounded shadow p-4 flex flex-col">
          <h2 class="font-semibold">{{ plan.name }}</h2>
          <p class="text-sm text-gray-600 mb-2">{{ plan.descrition?.slice(0,120) }}</p>
          <p class="text-sm mb-2">Dias: {{ plan.days }} | Valor: R$ {{ Number(plan.price).toFixed(2).replace('.', ',') }}</p>
          <span class="self-start px-2 py-1 text-xs rounded" :class="plan.active ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-700'">
            {{ plan.active ? 'Ativo' : 'Inativo' }}
          </span>
          <div class="mt-auto flex gap-2 pt-2">
            <Link :href="route('plans.edit', plan.id)" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</Link>
            <Link as="button" method="delete" :href="route('plans.destroy', plan.id)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" preserve-scroll>Excluir</Link>
          </div>
        </div>
        <p v-if="plans.length === 0" class="text-center col-span-full">Nenhum plano cadastrado.</p>
      </div>
    </div>
  </AdminLayout>
</template>
