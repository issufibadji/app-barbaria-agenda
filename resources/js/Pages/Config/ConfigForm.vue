<template>
  <form @submit.prevent="onSubmit" class="space-y-4">
    <div>
      <label class="block mb-1">Chave</label>
      <input v-model="form.key" type="text" class="input" required />
    </div>
    <div>
      <label class="block mb-1">Valor</label>
      <input v-model="form.value" type="text" class="input" />
    </div>
    <div class="flex gap-2">
      <Link :href="route('config.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
      <button type="submit" class="px-4 py-2 bg-brown-700 text-white rounded hover:bg-brown-600">
        {{ isEditing ? 'Salvar' : 'Criar' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({ key: '', value: '' })
  }
})
const emit = defineEmits(['submit'])

const form = ref({
  key: props.modelValue.key,
  value: props.modelValue.value
})

const isEditing = computed(() => !!props.modelValue.id)

function onSubmit() {
  emit('submit', form.value)
}
</script>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brown-500 focus:ring-brown-500;
}
</style>
