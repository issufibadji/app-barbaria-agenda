<script setup>
import AddressForm from './AddressForm.vue'
const props = defineProps({ establishments: Object })
</script>

<template>
  <AddressForm mode="create" :establishments="establishments" />
</template>
