<template>
  <div>
    <Head title="Editar Menu" />
    <!-- <h1 class="text-2xl font-bold mb-4 text-violet-800">Editar Menu</h1> -->
    <Form :menu="menu" :parents="parents" :submit-url="`/menus/${menu.id}`" method="put" />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Form from './Form.vue'
import { defineProps } from 'vue'

const props = defineProps({
  menu: Object,
  parents: Array
})
</script>
