<script setup>
import ProfessionalForm from './ProfessionalForm.vue'
const props = defineProps({ users: Object, establishments: Object })
</script>

<template>
  <ProfessionalForm mode="create" :users="users" :establishments="establishments" />
</template>
