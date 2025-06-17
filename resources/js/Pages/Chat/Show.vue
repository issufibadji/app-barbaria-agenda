<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  establishment: Object
})
</script>

<template>
  <GuestLayout>
    <Head :title="`Chat - ${props.establishment.name}`" />
    <div class="p-4">
      <h1 class="text-xl font-bold mb-4">Chat Manual - {{ props.establishment.name }}</h1>
      <p class="text-gray-700">Esta é uma área de chat manual. Funcionalidades completas ainda serão implementadas.</p>
    </div>
  </GuestLayout>
</template>
