<script setup>
import { useForm, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user) // <-- forma correta

const form = useForm({
  name: user.value.name || '',
  email: user.value.email || '',
  current_password: '',
  password: '',
  password_confirmation: ''
})

function submitForm() {
  form.post(route('profile.update'), {
    preserveScroll: true,
  })
}

function deleteAccount() {
  if (confirm('Tem certeza que deseja excluir sua conta?')) {
    router.delete(route('profile.destroy'))
  }
}
</script>

<template>
  <div class="mt-6 border-t pt-6">
    <h2 class="text-lg font-semibold text-violet-800 dark:text-violet-100">Autenticação em 2 Fatores (2FA)</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
      <!-- Nome -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" v-model="form.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" v-model="form.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>
    </div>

    <!-- Senha -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Senha Atual</label>
        <input type="password" v-model="form.current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Nova Senha</label>
        <input type="password" v-model="form.password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
        <input type="password" v-model="form.password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>
    </div>

    <!-- Botões -->
    <div class="mt-6 flex items-center gap-4">
      <button @click="submitForm" type="button" class="bg-violet-600 hover:bg-violet-700 text-white font-semibold px-4 py-2 rounded">
        Salvar alterações
      </button>
      <button @click="deleteAccount" type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
        Excluir Conta
      </button>
    </div>
  </div>
</template>
