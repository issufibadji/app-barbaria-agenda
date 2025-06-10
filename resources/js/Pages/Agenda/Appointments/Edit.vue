<script setup>
import AppointmentForm from './AppointmentForm.vue'
const props = defineProps({ appointment: Object, services: Object, clients: Object })
</script>

<template>
  <AppointmentForm mode="edit" :appointment="appointment" :services="services" :clients="clients" />
</template>
