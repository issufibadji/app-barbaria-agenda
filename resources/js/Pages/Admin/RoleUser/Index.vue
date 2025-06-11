<template>
<AdminLayout>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Atribuir/Remover Papel de Usuário</h1>

    <div class="overflow-x-auto bg-white dark:bg-brown-800 rounded shadow">
      <table class="min-w-full text-sm table-auto">
        <thead class="bg-brown-100 dark:bg-brown-700 text-left text-brown-800 dark:text-white">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Usuário</th>
            <th class="px-4 py-3">E-mail</th>
            <th class="px-4 py-3">Papéis</th>
             <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Atribuir Papel</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t border-gray-200 dark:border-brown-600">
            <!-- ID -->
            <td class="px-4 py-2">{{ user.id }}</td>
            <!-- Nome -->
            <td class="px-4 py-2">{{ user.name }}</td>
            <!-- E-mail -->
            <td class="px-4 py-2">{{ user.email }}</td>
            <!-- Status -->
            <td class="px-4 py-2"> Ativo</td>
            <!-- Roles -->
            <td class="px-4 py-2 space-x-1">
              <span
                v-for="role in user.roles"
                :key="role.id"
                class="inline-flex items-center bg-brown-600 text-white px-2 py-1 rounded text-xs"
              >
                {{ role.name }}
                <button
                  @click="removeRole(user.id, role.id)"
                  class="ml-1 text-white hover:text-red-200"
                  title="Remover"
                >
                  <i class="fas fa-times-circle text-xs"></i>
                </button>
              </span>
              <span v-if="user.roles.length === 0" class="text-gray-400 italic">Sem papéis</span>
            </td>

            <!-- Atribuição -->
            <td class="px-4 py-2">
              <form @submit.prevent="assignRole(user.id)">
                <div class="flex items-center space-x-2">
                  <select
                    v-model="selectedRoles[user.id]"
                    class="border rounded px-2 py-1 text-sm w-full"
                  >
                    <option value="">Selecione uma role</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                      {{ role.name }}
                    </option>
                  </select>
                  <button
                    type="submit"
                    class="bg-mint-600 text-white px-3 py-1 rounded hover:bg-mint-700 text-sm"
                  >
                    Atribuir
                  </button>
                </div>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
 </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
const props = defineProps({
  users: Array,
  roles: Array,
})

const selectedRoles = ref({})

function assignRole(userId) {
  if (selectedRoles.value[userId]) {
    router.post(`/roles-user`, {
      user_id: userId,
      role_id: selectedRoles.value[userId],
    }, {
      onSuccess: () => {
        selectedRoles.value[userId] = ''
      }
    })
  }
}

function removeRole(userId, roleId) {
  if (confirm('Remover esse papel do usuário?')) {
    router.delete(`/roles-user`, {
      data: {
        user_id: userId,
        role_id: roleId,
      }
    })
  }
}
</script>
