<script setup>
import ProfessionalForm from './ProfessionalForm.vue'
const props = defineProps({ professional: Object, users: Object, establishments: Object })
</script>

<template>
  <ProfessionalForm mode="edit" :professional="professional" :users="users" :establishments="establishments" />
</template>
