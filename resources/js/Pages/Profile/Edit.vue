<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ProfileInformationForm from './Partials/ProfileInformationForm.vue'
import { usePage } from '@inertiajs/vue3'
import TwoFactorSetup from './TwoFactorSetup.vue'

defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  qrCodeUrl: String,
  secretKey: String,
})
const page = usePage()
const user = page.props.auth.user
</script>

<template>
  <AdminLayout>
    <main class="p-6">
      <h1 class="text-2xl font-bold mb-4 text-violet-800">Perfil</h1>

      <div class="space-y-8">
        <!-- Formulário unificado -->
        <ProfileInformationForm :user="user" />

        <!-- 2FA -->
        <div class="bg-violet-100 p-4 rounded shadow">
          <h2 class="text-lg font-semibold mb-2">Segurança</h2>
          <p class="text-sm text-gray-700 mb-4">
            Configure ou desative a autenticação em dois fatores para sua conta.
          </p>
           <TwoFactorSetup
            :qr-code-url="qrCodeUrl"
            :secret-key="secretKey"
            :user="user"
            />

        </div>
      </div>
    </main>
  </AdminLayout>
</template>
