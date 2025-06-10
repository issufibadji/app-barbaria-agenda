<script setup>
import ClientForm from './ClientForm.vue'
const props = defineProps({
  users: Object
})
</script>

<template>
  <ClientForm mode="create" :users="users" />
</template>
