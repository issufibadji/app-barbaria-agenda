<template>
  <AdminLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Editar Configura\u00e7\u00e3o</h1>
      <ConfigForm :model-value="config" @submit="handleSubmit" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfigForm from '@/Pages/Config/ConfigForm.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  config: Object
})

function handleSubmit(form) {
  router.put(route('config.update', props.config.id), form)
}
</script>
