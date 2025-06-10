<script setup>
import PaymentForm from './PaymentForm.vue'
const props = defineProps({ payment: Object, establishments: Object, plans: Object })
</script>

<template>
  <PaymentForm mode="edit" :payment="payment" :establishments="establishments" :plans="plans" />
</template>
