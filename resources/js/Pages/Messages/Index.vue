<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  messages:{
    type:Object,
    default: () => ({ data: [], links: [] })
  }
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-brown-800">Gestão de Mensagens</h1>
        <Link :href="route('messages.create')" class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700">+ Mensagem</Link>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="msg in messages" :key="msg.id" class="bg-white rounded shadow p-4 flex flex-col">
          <h2 class="font-semibold">{{ msg.type }}</h2>
          <p class="text-sm text-gray-600 mb-2">{{ msg.message.slice(0,120) }}</p>
          <p class="text-sm mb-4">Estab.: {{ msg.establishment?.name || '—' }}</p>
          <div class="mt-auto flex gap-2">
            <Link :href="route('messages.edit', msg.id)" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</Link>
            <Link as="button" method="delete" :href="route('messages.destroy', msg.id)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" preserve-scroll>Excluir</Link>
          </div>
        </div>
        <p v-if="messages?.length === 0" class="text-center col-span-full">Nenhuma mensagem cadastrada.</p>
      </div>
    </div>
  </AdminLayout>
</template>
