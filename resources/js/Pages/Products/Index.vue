<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  products: Object
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-violet-800">Gestão de Produtos</h1>
        <Link :href="route('products.create')" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">+ Produto</Link>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="product in products.data" :key="product.id" class="bg-white rounded shadow overflow-hidden">
          <img :src="product.image ? '/storage/' + product.image : '/storage/images/product-default.jpg'" class="h-48 w-full object-cover" alt="Imagem do produto" />
          <div class="p-4 space-y-2">
            <h2 class="font-semibold">{{ product.name }}</h2>
            <p class="text-sm text-gray-600">{{ product.descrition?.slice(0, 120) }}</p>
            <p class="text-sm font-medium">Valor: R$ {{ Number(product.price).toFixed(2).replace('.', ',') }}</p>
            <div class="flex gap-2 mt-2">
              <Link :href="route('products.edit', product.uuid)" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</Link>
              <Link as="button" method="delete" :href="route('products.destroy', product.uuid)" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" preserve-scroll>Excluir</Link>
            </div>
          </div>
        </div>
        <p v-if="products.data.length === 0" class="text-center col-span-full">Nenhum produto cadastrado.</p>
      </div>
      <div class="mt-4">
        <Pagination :links="products.links" />
      </div>
    </div>
  </AdminLayout>
</template>
