<template>
<AdminLayout>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Criar Permissão</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block mb-1 font-medium">Nome</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
        <span class="text-sm text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
      </div>

      <div class="mb-4">
        <label class="block mb-1 font-medium">Tag</label>
        <input v-model="form.tag" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="flex justify-end gap-2">
        <Link href="/permissions" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Voltar</Link>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
      </div>
    </form>
  </div>
</AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
const form = useForm({
  name: '',
  tag: '',
})

function submit() {
  form.post('/permissions')
}
</script>
