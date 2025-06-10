<script setup>
import MessageForm from './MessageForm.vue'
const props = defineProps({ establishments: Object })
</script>

<template>
  <MessageForm mode="create" :establishments="establishments" />
</template>
