<script setup>
import ServiceForm from './ServiceForm.vue'
const props = defineProps({ service: Object, professionals: Object })
</script>

<template>
  <ServiceForm mode="edit" :service="service" :professionals="professionals" />
</template>
