<template>
  <div>
    <Head title="Criar Menu" />
    <!-- <h1 class="text-2xl font-bold mb-4 text-violet-800">Criar Novo Menu</h1> -->
    <Form :menu="{}" :parents="parents" submit-url="/menus" method="post" />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Form from './Form.vue'
import { defineProps } from 'vue'

const props = defineProps({
  parents: Array
})
</script>

