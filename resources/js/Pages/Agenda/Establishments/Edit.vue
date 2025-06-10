<script setup>
import EstablishmentForm from './EstablishmentForm.vue'
const props = defineProps({ establishment: Object })
</script>

<template>
  <EstablishmentForm :establishment="establishment" mode="edit" />
</template>
