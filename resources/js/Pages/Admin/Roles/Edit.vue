<template>
<AdminLayout>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Editar Papel</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block font-medium mb-1">Nome do Papel</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
        <span class="text-sm text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
      </div>

      <div class="mb-4">
        <label class="block font-medium mb-1">Permissões</label>
        <div class="max-h-48 overflow-y-auto border p-2 rounded">
          <label v-for="permission in permissions" :key="permission.id" class="flex items-center space-x-2 text-sm">
            <input
              type="checkbox"
              :value="permission.name"
              v-model="form.permissions"
              class="rounded text-brown-600"
            />
            <span>{{ permission.name }}</span>
          </label>
        </div>
      </div>

      <div class="flex justify-end gap-2">
        <Link href="/roles" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Voltar</Link>
        <button type="submit" class="px-4 py-2 bg-brown-600 text-white rounded hover:bg-brown-700">Salvar</button>
      </div>
    </form>
  </div>
  </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
const props = defineProps({
  role: Object,
  permissions: Array,
})

const form = useForm({
  name: props.role.name,
  permissions: props.role.permissions.map(p => p.name),
})

function submit() {
  form.put(`/roles/${props.role.id}`)
}
</script>
