<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Editar papel</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-sm font-medium">Nome do papel</label>
        <input v-model="form.name" type="text" class="mt-1 w-full rounded border px-3 py-2" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Permissões</label>
        <div v-for="perm in permissions" :key="perm.id">
          <label class="flex items-center">
            <input type="checkbox" :value="perm.name" v-model="form.permissions" class="mr-2" />
            {{ perm.name }}
          </label>
        </div>
      </div>

      <div class="mt-6">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          Atualizar
        </button>
        <Link href="/roles" class="ml-4 text-sm text-gray-600 hover:underline">Cancelar</Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  role: Object,
  permissions: Array,
})

const form = reactive({
  name: props.role.name,
  permissions: props.role.permissions.map(p => p.name),
})

function submit() {
  router.put(`/roles/${props.role.id}`, form)
}
</script>
