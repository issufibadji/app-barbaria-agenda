<script setup>
import PlanForm from './PlanForm.vue'
const props = defineProps({ plan: Object })
</script>

<template>
  <PlanForm mode="edit" :plan="plan" />
</template>
