<script setup>
defineProps({
  links: Array
})
</script>

<template>
  <div class="mt-4 flex space-x-1">
    <template v-for="link in links" :key="link.label">
      <span v-if="link.url === null" v-html="link.label" class="px-3 py-1 text-sm text-gray-400" />
      <Link
        v-else
        :href="link.url"
        class="px-3 py-1 text-sm rounded"
        :class="link.active ? 'bg-violet-600 text-white' : 'bg-white text-violet-700 hover:bg-violet-100'"
        v-html="link.label"
      />
    </template>
  </div>
</template>
