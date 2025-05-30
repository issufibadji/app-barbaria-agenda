<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  user: Object,
  mode: String, // 'create' ou 'edit'
})

const form = useForm({
  name: props.user?.name || '',
  email: props.user?.email || '',
  password: '',
  password_confirmation: '',
  status: props.user?.status || 'active',
  two_factor_enabled: props.user?.two_factor_enabled ?? false,
  email_verified_at: props.user?.email_verified_at
    ? new Date(props.user.email_verified_at).toISOString().slice(0, 16)
    : null,
})

function submit() {
  if (props.mode === 'edit') {
    form.put(route('users.update', props.user.id))
  } else {
    form.post(route('users.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Usuário' : 'Criar Usuário'" />

    <div class="py-10 max-w-3xl mx-auto px-4">
      <h1 class="text-2xl font-bold text-violet-900 dark:text-white mb-6">
        {{ props.mode === 'edit' ? 'Editar Usuário' : 'Criar Novo Usuário' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Nome -->
        <div>
          <label for="name" class="block text-sm font-medium text-violet-700">Nome</label>
          <input v-model="form.name" id="name" type="text" class="input" />
          <InputError :message="form.errors.name" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-violet-700">E-mail</label>
          <input v-model="form.email" id="email" type="email" class="input" />
          <InputError :message="form.errors.email" class="mt-1" />
        </div>

        <!-- Senha -->
        <div>
          <label for="password" class="block text-sm font-medium text-violet-700">Senha</label>
          <input v-model="form.password" id="password" type="password" class="input" />
          <InputError :message="form.errors.password" class="mt-1" />
        </div>

        <!-- Confirmação de senha -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-violet-700">Confirmar Senha</label>
          <input v-model="form.password_confirmation" id="password_confirmation" type="password" class="input" />
          <InputError :message="form.errors.password_confirmation" class="mt-1" />
        </div>

        <!-- Status -->
        <div>
          <label for="status" class="block text-sm font-medium text-violet-700">Status</label>
          <select v-model="form.status" id="status" class="input">
            <option value="active">Ativo</option>
            <option value="inactive">Inativo</option>
          </select>
          <InputError :message="form.errors.status" class="mt-1" />
        </div>

        <!-- 2FA -->
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" v-model="form.two_factor_enabled" class="mr-2" />
            Ativar autenticação em duas etapas (2FA)
          </label>
          <InputError :message="form.errors.two_factor_enabled" class="mt-1" />
        </div>

        <!-- Email verificado em -->
        <div>
          <label for="email_verified_at" class="block text-sm font-medium text-violet-700">E-mail verificado em</label>
          <input v-model="form.email_verified_at" id="email_verified_at" type="datetime-local" class="input" />
          <InputError :message="form.errors.email_verified_at" class="mt-1" />
        </div>

        <!-- Botão -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="inline-flex items-center px-4 py-2 bg-violet-700 border border-transparent rounded-md font-semibold text-white hover:bg-violet-600"
            :disabled="form.processing"
          >
            {{ props.mode === 'edit' ? 'Atualizar' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500;
}
</style>
