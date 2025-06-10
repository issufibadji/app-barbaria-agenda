<script setup>
import ScheduleForm from './ScheduleForm.vue'
const props = defineProps({ professionals: Object })
</script>

<template>
  <ScheduleForm mode="create" :professionals="professionals" />
</template>
