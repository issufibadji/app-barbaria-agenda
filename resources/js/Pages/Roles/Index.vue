<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Papéis e Permissões</h1>

    <div class="flex justify-end mb-4">
      <Link href="/roles/create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Novo Papel
      </Link>
    </div>

    <div v-for="role in roles" :key="role.id" class="mb-4 p-4 border rounded shadow">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">{{ role.name }}</h2>
        <div class="space-x-2">
          <Link :href="`/roles/${role.id}/edit`" class="text-blue-600 hover:underline">Editar</Link>
          <button @click="deleteRole(role.id)" class="text-red-600 hover:underline">Excluir</button>
        </div>
      </div>
      <ul class="mt-2 list-disc list-inside text-sm text-gray-700">
        <li v-for="perm in role.permissions" :key="perm.id">{{ perm.name }}</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

defineProps({
  roles: Array,
})

function deleteRole(id) {
  if (confirm('Deseja realmente excluir este papel?')) {
    router.delete(`/roles/${id}`)
  }
}
</script>
