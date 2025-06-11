<template>
  <AdminLayout>
    <div class="p-6 max-w-4xl mx-auto bg-white dark:bg-brown-800 rounded shadow">
      <h1 class="text-2xl font-bold mb-4">Detalhes da Auditoria</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
        <div><strong>ID:</strong> {{ audit.id }}</div>
        <div><strong>Evento:</strong> {{ audit.event }}</div>
        <div><strong>Usuário:</strong> {{ audit.user?.name || '-' }}</div>
        <div><strong>Modelo:</strong> {{ audit.auditable_type }}</div>
        <div><strong>ID do Registro:</strong> {{ audit.auditable_id }}</div>
        <div><strong>Data:</strong> {{ new Date(audit.created_at).toLocaleString() }}</div>
        <div><strong>IP:</strong> {{ audit.ip_address }}</div>
        <div class="md:col-span-2"><strong>URL:</strong> {{ audit.url }}</div>
        <div class="md:col-span-2"><strong>User Agent:</strong> {{ audit.user_agent }}</div>
        <div class="md:col-span-2"><strong>Tags:</strong> {{ audit.tags || '-' }}</div>
      </div>

      <div>
        <h2 class="text-lg font-semibold mb-2">Valores Antigos</h2>
        <ul class="bg-gray-100 dark:bg-brown-700 p-4 rounded text-sm mb-4">
          <li v-for="(value, key) in audit.old_values" :key="key">
            <strong>{{ key }}:</strong> {{ value }}
          </li>
        </ul>

        <h2 class="text-lg font-semibold mb-2">Valores Novos</h2>
        <ul class="bg-gray-100 dark:bg-brown-700 p-4 rounded text-sm">
          <li v-for="(value, key) in audit.new_values" :key="key">
            <strong>{{ key }}:</strong> {{ value }}
          </li>
        </ul>
      </div>

      <div class="mt-6 text-right">
        <Link href="/audits" class="text-sm text-blue-600 hover:underline">← Voltar para a lista</Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  audit: Object
})
</script>
