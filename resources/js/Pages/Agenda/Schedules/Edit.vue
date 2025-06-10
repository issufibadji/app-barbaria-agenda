<script setup>
import ScheduleForm from './ScheduleForm.vue'
const props = defineProps({ schedule: Object, professionals: Object })
</script>

<template>
  <ScheduleForm mode="edit" :schedule="schedule" :professionals="professionals" />
</template>
