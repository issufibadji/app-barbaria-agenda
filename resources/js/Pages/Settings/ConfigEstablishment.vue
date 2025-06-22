<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  establishment: Object,
  services: Array,
  professionals: Array
})

const hasIncompleteData = ref(
  !props.establishment?.name ||
  !props.establishment?.phone ||
  !props.establishment?.address
)
</script>

<template>
  <Head title="Configurações do Estabelecimento" />
  <AdminLayout>
  <div class="max-w-7xl mx-auto py-10 px-4 space-y-6">
    <h1 class="text-2xl font-semibold text-brown-800 dark:text-white">Configurações da Barbearia</h1>

    <!-- Alerta de dados incompletos -->
    <div
      v-if="hasIncompleteData"
      class="bg-yellow-100 text-yellow-800 p-4 rounded-lg border border-yellow-300 flex items-center gap-2"
    >
      <i class="fas fa-exclamation-triangle"></i>
      <span>Preencha os dados do estabelecimento para ativar sua página de agendamento.</span>
    </div>

    <!-- Dados principais -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-6">
      <h2 class="text-lg font-bold text-brown-900 dark:text-white mb-4">Dados do Estabelecimento</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <p class="text-sm text-gray-500">Nome</p>
          <p class="text-base font-medium">{{ establishment?.name || '---' }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Telefone</p>
          <p class="text-base font-medium">{{ establishment?.phone || '---' }}</p>
        </div>
        <div class="md:col-span-2">
          <p class="text-sm text-gray-500">Endereço</p>
          <p class="text-base font-medium">{{ establishment?.address || '---' }}</p>
        </div>
      </div>
      <div class="mt-4 text-right">
        <Link
          v-if="establishment?.uuid"
          :href="route('establishments.edit', establishment.uuid)"
          class="text-sm text-blue-600 hover:underline"
        >
          Editar dados
        </Link>
        <span
          v-else
          class="text-sm text-gray-400 italic"
        >
          Estabelecimento não disponível para edição
        </span>
      </div>
    </div>

    <!-- Serviços -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-6">
      <h2 class="text-lg font-bold text-brown-900 dark:text-white mb-4">Serviços</h2>
      <ul class="space-y-2">
        <li
          v-for="service in services"
          :key="service.id"
          class="flex justify-between border-b border-brown-100 pb-2"
        >
          <span>{{ service.name }} ({{ service.duration }} min)</span>
          <span class="text-green-600">R$ {{ service.price.toFixed(2) }}</span>
        </li>
      </ul>
      <div class="mt-4 text-right">
        <Link href="/services" class="text-sm text-blue-600 hover:underline">Gerenciar serviços</Link>
      </div>
    </div>

    <!-- Profissionais -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-6">
      <h2 class="text-lg font-bold text-brown-900 dark:text-white mb-4">Profissionais</h2>
      <ul class="space-y-2">
        <li
          v-for="professional in professionals"
          :key="professional.id"
          class="border-b border-brown-100 pb-2"
        >
          {{ professional.name }}
        </li>
      </ul>
      <div class="mt-4 text-right">
        <Link href="/professionals" class="text-sm text-blue-600 hover:underline">Gerenciar profissionais</Link>
      </div>
    </div>

    <!-- Link de Agendamento -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-6">
      <h2 class="text-lg font-bold text-brown-900 dark:text-white mb-4">Link de Agendamento</h2>
      <p class="text-sm text-gray-600 mb-2">
        Compartilhe esse link com seus clientes:
      </p>
      <p class="font-mono bg-gray-100 text-sm p-2 rounded">
        {{ establishment?.link || '---' }}
      </p>
      <div class="mt-4 text-right">
        <Link href="/settings/chat-link" class="text-sm text-blue-600 hover:underline">
          Configurar link de agendamento
        </Link>
      </div>
    </div>
  </div>
  </AdminLayout>
</template>
