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
import { ref, computed } from 'vue'

const props = defineProps({
  duration: {
    type: Number,
    default: 4000,
  },
})

const message = ref('')
const type = ref('success')
const show = ref(false)

function showToast(msg, msgType = 'success') {
  message.value = msg
  type.value = msgType
  show.value = true

  setTimeout(() => {
    show.value = false
  }, props.duration)
}

const toastClass = computed(() => {
  return type.value === 'success'
    ? 'bg-green-500 text-white'
    : 'bg-red-500 text-white'
})

const iconClass = computed(() => {
  return type.value === 'success'
    ? 'mdi mdi-check-circle-outline'
    : 'mdi mdi-alert-circle-outline'
})

defineExpose({ showToast })
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
