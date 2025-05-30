<script setup>
import UserForm from './UserForm.vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})
</script>

<template>
  <UserForm mode="edit" :user="user" />
</template>
