<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  plans: {
    type: Object,
    default: () => ({ data: [], links: [] })
  }
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-bold text-brown-800">Gestão de Planos</h1>
        <Link :href="route('plans.create')" class="bg-brown-700 text-white px-5 py-2 rounded-md shadow hover:bg-brown-800 transition">
          + Plano
        </Link>
      </div>

      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(plan, index) in plans"
          :key="plan.id"
          :class="[
            'rounded-3xl p-6 shadow-md hover:shadow-lg transition-all duration-300 flex flex-col justify-between border',
            index === 0 ? 'bg-white border-gray-200' :
            index === 1 ? 'bg-[#f7e9ca] border-yellow-200' :
            'bg-[#e4d3ff] border-purple-200'
          ]"
        >
          <!-- Nome -->
          <h3 class="text-xl font-semibold text-gray-900">{{ plan.name }}</h3>

          <!-- Preço -->
          <div class="my-6 flex items-baseline">
            <span class="text-4xl font-extrabold text-gray-900 mr-1">R$ {{ Number(plan.price).toFixed(2).replace('.', ',') }}</span>
            <span class="text-sm text-gray-700">/ {{ plan.days }} dias</span>
          </div>

          <!-- Descrição -->
          <p class="text-sm text-gray-600 mb-4">{{ plan.descrition?.slice(0, 120) }}</p>

          <!-- Botão Começar -->
          <button
            class="w-full mb-6 py-2 px-4 bg-brown-800 text-white rounded-md font-semibold hover:bg-brown-900 transition inline-flex items-center justify-center gap-2 group">
            Começar
            <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
          </button>

          <!-- Lista de Benefícios Dinâmicos -->
          <ul v-if="plan.features?.length" class="mb-6 space-y-2 text-sm text-gray-800">
            <li v-for="(item, i) in plan.features" :key="i" class="flex items-center gap-2">
              <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8.25 8.25a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8.25 12.586l7.043-7.043a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
              {{ item }}
            </li>
          </ul>
          <p v-else class="text-sm text-gray-500 mb-6 italic">Nenhum benefício listado.</p>

          <!-- Status -->
          <span
            class="inline-block w-fit px-2 py-1 text-xs font-semibold rounded mb-4"
            :class="plan.active ? 'bg-green-200 text-green-800' : 'bg-gray-300 text-gray-700'">
            {{ plan.active ? 'Ativo' : 'Inativo' }}
          </span>

          <!-- Ações -->
          <div class="mt-auto flex gap-2">
            <Link
              :href="route('plans.edit', plan.id)"
              class="flex-1 text-center px-4 py-2 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold">
              ✏️ Editar
            </Link>
            <Link
              as="button"
              method="delete"
              :href="route('plans.destroy', plan.id)"
              class="flex-1 text-center px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 font-semibold"
              preserve-scroll>
              🗑️ Excluir
            </Link>
          </div>
        </div>
      </div>

      <p v-if="plans?.length === 0" class="text-center text-gray-500 mt-10">Nenhum plano cadastrado.</p>
    </div>
  </AdminLayout>
</template>
