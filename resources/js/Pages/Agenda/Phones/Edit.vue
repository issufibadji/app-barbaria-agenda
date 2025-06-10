<script setup>
import PhoneForm from './PhoneForm.vue'
const props = defineProps({ phone: Object, professionals: Array, establishments: Array })
</script>
<template>
  <PhoneForm :phone="phone" :professionals="professionals" :establishments="establishments" mode="edit" />
</template>
