<template>
  <div class="bg-black text-white font-sans">
    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-4 bg-black border-b border-gray-800">
      <div class="text-2xl font-bold">BARBER</div>
      <nav class="hidden md:flex gap-6 items-center text-sm uppercase">
        <a href="#" class="hover:text-yellow-400">Home</a>
        <a href="#about" class="hover:text-yellow-400">About Us</a>
        <a href="#prices" class="hover:text-yellow-400">Preços</a>
        <a href="#contact" class="hover:text-yellow-400">Contact</a>
        <button class="ml-4 bg-yellow-400 text-black font-semibold px-4 py-2 rounded hover:bg-yellow-300 transition">
          Marque uma consulta
        </button>
      </nav>
      <button class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </header>

    <!-- Hero Preços -->
    <section id="prices" class="relative bg-cover bg-center h-[400px]" style="background-image: url('/images/templates/barbershop/barber-cutting.jpg')">
      <div class="absolute inset-0 bg-black/70"></div>
      <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-white">PREÇOS</h1>
        <p class="mt-4 text-lg text-gray-300">Obtenha uma gama completa de serviços premium.</p>
        <button class="mt-6 bg-yellow-400 text-black px-6 py-3 font-semibold rounded hover:bg-yellow-300 transition">
          Marque uma consulta
        </button>
      </div>
      <p class="absolute bottom-4 right-4 text-gray-500 text-xs">Imagem de Freepik</p>
    </section>

    <!-- Nossos Preços Lista -->
    <section class="px-6 py-16 bg-black text-white">
      <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos Preços</h2>
        <div class="space-y-4 text-sm">
          <div v-for="(row, i) in priceRows" :key="i" class="grid grid-cols-4 gap-4">
            <span>{{ row[0] }}</span>
            <span class="font-semibold">{{ row[1] }}</span>
            <span>{{ row[2] }}</span>
            <span class="font-semibold">{{ row[3] }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Tabs de Serviços -->
    <section class="px-6 py-16 bg-white text-black">
      <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-8">Oferecemos serviços de primeira classe</h2>
        <!-- Tabs -->
        <div class="flex justify-center space-x-4 mb-8">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="['px-4 py-2 rounded', activeTab===tab.id ? 'bg-yellow-400 text-black' : 'bg-gray-200 text-gray-700']">
            {{ tab.label }}
          </button>
        </div>
        <!-- Conteúdo do Tab -->
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <img :src="activeContent.image" alt="Serviço" class="rounded-lg shadow-lg w-full h-auto object-cover" />
          <div>
            <p class="text-gray-600 text-sm mb-4">Imagem de Freepik</p>
            <p class="leading-relaxed">{{ activeContent.text }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer simples -->
    <footer class="px-6 py-6 bg-gray-800 text-gray-400 text-center text-sm">
      <p>© 2025 Barber. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const priceLeft = [
  { title: 'Corte de cabelo normal', price: '$34+' },
  { title: 'Barbear real', price: '$35+' },
  { title: 'Corte de cabelo masculino especial', price: '$75+' },
  { title: 'Shampoo de massagem', price: '$12+' },
]
const priceRight = [
  { title: 'Corte de cabelo + barba real', price: '$60+' },
  { title: 'Corte de cabelo + aparar barba', price: '$65+' },
  { title: 'Cor masculina', price: '$55+' },
  { title: 'Corte de cabelo longo', price: '$55+' },
]

// Combina as duas colunas em linhas de quatro células
const priceRows = priceLeft.map((left, i) => [
  left.title, left.price,
  priceRight[i].title, priceRight[i].price
])

const tabs = [
  { id: 'tab1', label: 'Beard and Mustache Trim' },
  { id: 'tab2', label: 'Royal Shave' },
  { id: 'tab3', label: 'Hair Coloring' },
  { id: 'tab4', label: 'Cuts and Fades' },
]

const contents = {
  tab1: {
    image: '/images/templates/barbershop/close-up-man-getting-groomed.jpg',
    text: 'Detalhes sobre o serviço de aparar barba e bigode. Descrição breve e envolvente.'
  },
  tab2: {
    image: '/images/templates/barbershop/service-shave.png',
    text: 'Detalhes sobre o Royal Shave com navalha. Conforto e precisão.'
  },
  tab3: {
    image: '/images/templates/barbershop/blog-4-1000x731.jpg',
    text: 'Detalhes sobre coloração de cabelos. Cores modernas e duradouras.'
  },
  tab4: {
    image: '/images/templates/barbershop/barber.jpg',
    text: 'Detalhes sobre cortes e fades. Estilo personalizado para você.'
  },
}

const activeTab = ref('tab1')
const activeContent = computed(() => contents[activeTab.value])
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
