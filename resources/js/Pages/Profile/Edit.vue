<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import TwoFactorSetup from './Partials/TwoFactorSetup.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <AdminLayout>
        <main class="flex-1 p-6 bg-white dark:bg-violet-900 bg-gradient-to-r from-white to-violet-100 dark:from-violet-900 dark:to-violet-800 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-violet-900 dark:text-white mb-4">Perfil</h1>

                <div class="space-y-6">
                    <div class="bg-violet-100 p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div class="bg-violet-100 p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>

                    <div class="bg-violet-100 p-4 shadow sm:rounded-lg sm:p-8">
                        <DeleteUserForm class="max-w-xl" />
                    </div>

                    <div class="bg-violet-100 p-4 shadow sm:rounded-lg sm:p-8">
                    <TwoFactorSetup class="max-w-xl" />
                    </div>

                    <div class="bg-violet-100 p-4 shadow sm:rounded-lg sm:p-8">
                    <h2 class="text-lg font-semibold text-violet-900 mb-2">Segurança</h2>
                    <p class="mb-4 text-sm text-gray-600">Configure ou desative a autenticação em dois fatores para sua conta.</p>
                    <Link
                        href="/profile/2fa/setup"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                        Acessar configuração de 2FA
                    </Link>
                    </div>

                </div>
            </div>
        </main>
    </AdminLayout>
</template>
