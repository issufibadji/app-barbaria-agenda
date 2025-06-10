<script setup>
import PhoneForm from './PhoneForm.vue'
const props = defineProps({ professionals: Array, establishments: Array })
</script>
<template>
  <PhoneForm :professionals="professionals" :establishments="establishments" mode="create" />
</template>
