<script setup>
import ServiceForm from './ServiceForm.vue'
const props = defineProps({ professionals: Object })
</script>

<template>
  <ServiceForm mode="create" :professionals="professionals" />
</template>
