<template>
  <transition name="fade">
    <div
      v-if="show && message"
      :class="toastClass"
      class="fixed top-5 right-5 z-50 px-4 py-3 rounded shadow-lg flex items-center gap-2"
    >
      <i :class="iconClass" class="text-xl"></i>
      <span>{{ message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const props = defineProps({
  message: String,
  type: {
    type: String,
    default: 'success', // 'success' | 'error'
  },
})

const show = ref(true)

onMounted(() => {
  setTimeout(() => (show.value = false), 4000)
})

const toastClass = computed(() => {
  return props.type === 'success'
    ? 'bg-green-500 text-white'
    : 'bg-red-500 text-white'
})

const iconClass = computed(() => {
  return props.type === 'success'
    ? 'mdi mdi-check-circle-outline'
    : 'mdi mdi-alert-circle-outline'
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
