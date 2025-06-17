<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Criar Configura\u00e7\u00e3o</h1>
      <ConfigForm @submit="handleSubmit" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfigForm from '@/Pages/Config/ConfigForm.vue'
import { router } from '@inertiajs/vue3'

function handleSubmit(form) {
  router.post(route('config.store'), form)
}
</script>
