<script setup>
import { Head,  usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
const user = usePage().props.auth.user


console.log("Roles:", user?.roles)
console.log("Permissions:", user?.permissions)
console.log('Usuário logado:', user)

</script>

<template>
  <Head title="Dashboard" />
  <AdminLayout>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-brown-900 dark:text-white mb-4">Dashboard</h1>

        <div class="p-6 bg-white dark:bg-brown-800 rounded-lg shadow-md">
          <p class="text-brown-600 dark:text-brown-200">
            This is a dark sidebar example with submenus.
          </p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

