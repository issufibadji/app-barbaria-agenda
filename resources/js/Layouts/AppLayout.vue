<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <header class="bg-white shadow dark:bg-gray-800">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl font-bold">
        <slot name="header" />
      </div>
    </header>
    <main class="p-4">
      <slot />
    </main>
  </div>
</template>
