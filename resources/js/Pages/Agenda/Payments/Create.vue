<script setup>
import PaymentForm from './PaymentForm.vue'
const props = defineProps({ establishments: Object, plans: Object })
</script>

<template>
  <PaymentForm mode="create" :establishments="establishments" :plans="plans" />
</template>
