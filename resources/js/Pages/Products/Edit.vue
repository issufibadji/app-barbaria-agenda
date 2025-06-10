<script setup>
import ProductForm from './ProductForm.vue'
const props = defineProps({
  product: Object
})
</script>

<template>
  <ProductForm mode="edit" :product="product" />
</template>
