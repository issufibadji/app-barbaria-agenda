<script setup>
import MessageForm from './MessageForm.vue'
const props = defineProps({ message: Object, establishments: Object })
</script>

<template>
  <MessageForm mode="edit" :message="message" :establishments="establishments" />
</template>
