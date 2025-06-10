<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Criar Cliente</h1>
      <ClientForm :users="users" @submit="handleSubmit" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ClientForm from '@/Pages/Clients/ClientForm.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  users: Object,
})

function handleSubmit(form) {
  router.post(route('clients.store'), form)
}
</script>
