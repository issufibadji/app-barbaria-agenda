<script setup>
import ClientForm from './ClientForm.vue'
const props = defineProps({
  client: Object,
  users: Object
})
</script>

<template>
  <ClientForm mode="edit" :client="client" :users="users" />
</template>
