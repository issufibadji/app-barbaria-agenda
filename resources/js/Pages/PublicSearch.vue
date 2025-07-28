<script setup>
import Layout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  services: {
    type: Array,
    default: () => []
  }
})

const categories = ['Beleza', 'Saúde', 'Consultoria']
const prices = ['Até R$50', 'R$50 - R$100', 'Acima de R$100']
const ratings = ['1+', '2+', '3+', '4+', '5']

const query = ref('')
const location = ref('')
const category = ref('')
const price = ref('')
const rating = ref('')

const submit = () => {
  // Lógica de busca será implementada no futuro
}
</script>

<template>
  <Layout>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto flex items-center justify-between p-4">
        <Link href="/">
          <img src="/images/logo.svg" alt="Tcham Services" class="h-10 w-auto" />
        </Link>
        <nav class="flex gap-6 text-sm">
          <Link href="/" class="text-gray-600 hover:text-gray-800">Início</Link>
          <Link href="/login" class="text-gray-600 hover:text-gray-800">Login</Link>
          <Link href="/register" class="text-gray-600 hover:text-gray-800">Cadastro</Link>
        </nav>
      </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 space-y-6">
      <form @submit.prevent="submit" class="bg-white shadow rounded p-4 grid gap-4 md:grid-cols-3">
        <input v-model="query" type="text" placeholder="Serviço desejado" class="border rounded p-2 w-full" />
        <input v-model="location" type="text" placeholder="Localização" class="border rounded p-2 w-full" />
        <select v-model="category" class="border rounded p-2 w-full">
          <option value="" disabled selected>Categoria</option>
          <option v-for="c in categories" :key="c" :value="c">{{ c }}</option>
        </select>
        <select v-model="price" class="border rounded p-2 w-full">
          <option value="" disabled selected>Preço</option>
          <option v-for="p in prices" :key="p" :value="p">{{ p }}</option>
        </select>
        <select v-model="rating" class="border rounded p-2 w-full">
          <option value="" disabled selected>Avaliação</option>
          <option v-for="r in ratings" :key="r" :value="r">{{ r }} estrelas</option>
        </select>
        <button type="submit" class="bg-brown-600 text-white rounded px-4 py-2">Buscar</button>
      </form>

      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="service in props.services" :key="service.id" class="bg-white shadow rounded p-4 flex flex-col justify-between">
          <div class="space-y-2">
            <h3 class="font-semibold text-lg">{{ service.name }}</h3>
            <p class="text-sm text-gray-600">{{ service.description }}</p>
            <div class="flex items-center text-sm">
              <span class="text-yellow-500 mr-1">⭐</span>
              {{ service.rating }}
            </div>
            <p class="font-medium">R$ {{ service.price }}</p>
          </div>
          <Link :href="route('chat.show', service.slug)" class="mt-4 bg-brown-600 text-white text-center py-2 rounded hover:bg-brown-700">Ver Perfil</Link>
        </div>
        <p v-if="props.services.length === 0" class="col-span-full text-center text-gray-600">Nenhum serviço encontrado.</p>
      </div>
    </main>

    <footer class="mt-10 p-4 text-center text-gray-500 text-sm">
      © 2025 Tcham Services
    </footer>
  </Layout>
</template>

<style scoped>
</style>
