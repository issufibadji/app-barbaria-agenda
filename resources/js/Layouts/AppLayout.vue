<script setup>
const props = defineProps({
  auth: Object,
})
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <header class="bg-white shadow dark:bg-gray-800">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl font-bold">
        <slot name="header" />
      </div>
    </header>

    <!-- Menu lateral ou superior -->
    <nav class="p-4 text-white bg-gray-700">
      <ul class="space-y-2">
        <li><Link href="/dashboard">Dashboard</Link></li>

        <li v-if="props.auth?.user?.roles.includes('admin')">
          <Link href="/roles">Gestão de Papéis</Link>
        </li>
      </ul>
    </nav>

    <main class="p-4">
      <slot />
    </main>
  </div>
</template>
