<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Editar Cliente</h1>
      <ClientForm
        :users="users"
        :model-value="client"
        @submit="handleSubmit"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ClientForm from '@/Pages/Clients/ClientForm.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  client: Object,
  users: Object,
})

function handleSubmit(form) {
  router.put(route('clients.update', { client: props.client.uuid }), form)
}
</script>
