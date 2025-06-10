<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ payments: Object })
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Pagamentos</h1>
        <Link :href="route('agendaai.payments.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Pagamento</Link>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="payment in payments" :key="payment.id" class="bg-white rounded shadow p-4 flex flex-col">
          <h2 class="font-semibold">Plano: {{ payment.plan?.name || '—' }}</h2>
          <p class="text-sm text-gray-600">Estab.: {{ payment.establishment?.name || '-' }}</p>
          <p v-if="payment.mercado_payment_id" class="text-sm mt-2">MercadoPago ID: {{ payment.mercado_payment_id }}</p>
          <div class="mt-auto flex gap-2 pt-2">
            <Link :href="route('agendaai.payments.edit', payment.id)" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</Link>
            <Link as="button" method="delete" :href="route('agendaai.payments.destroy', payment.id)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" preserve-scroll>Excluir</Link>
          </div>
        </div>
        <p v-if="payments.length === 0" class="text-center col-span-full">Nenhum pagamento cadastrado.</p>
      </div>
    </div>
  </AdminLayout>
</template>
