<script setup>
import AddressForm from './AddressForm.vue'
const props = defineProps({ address: Object, establishments: Object })
</script>

<template>
  <AddressForm mode="edit" :address="address" :establishments="establishments" />
</template>
