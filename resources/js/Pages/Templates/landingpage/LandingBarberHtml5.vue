<template>
  <div class="font-sans scroll-smooth">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full bg-transparent z-50">
      <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">
        <div class="text-white text-2xl font-bold flex items-center">
          <img src="/images/templates/barbershop/barber-shop-logo.jpg" alt="Logo" class="h-8 w-auto mr-2" />
          <span>BARBERSHOP</span>
        </div>
        <nav class="hidden md:flex space-x-6 text-white uppercase text-sm">
          <a href="#" class="hover:text-gray-300">Home</a>
          <a href="#services" class="hover:text-gray-300">Services</a>
          <a href="#about" class="hover:text-gray-300">About</a>
          <a href="#book" class="hover:text-gray-300">Book Now</a>
          <a href="#blog" class="hover:text-gray-300">Blog</a>
          <a href="#extras" class="hover:text-gray-300">Extras</a>
          <a href="#contact" class="px-4 py-2 bg-[#A5683E] rounded hover:bg-opacity-90">Make Appointment</a>
        </nav>
        <button class="md:hidden text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </header>

    <main class="pt-16 bg-black">
      <!-- Hero Slider -->
      <section class="relative h-[600px] overflow-hidden">
        <div
          v-for="(slide, idx) in slides"
          :key="idx"
          v-show="idx === currentSlide"
          class="absolute inset-0 bg-cover bg-center transition-opacity duration-700"
          :style="`background-image: url('${slide.image}')`"
        >
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-6 text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ slide.title }}</h1>
            <p class="max-w-2xl mb-6 text-lg">{{ slide.subtitle }}</p>
            <button class="bg-[#A5683E] px-6 py-3 rounded hover:bg-opacity-90 transition">{{ slide.cta }}</button>
          </div>
        </div>
        <!-- Arrows -->
        <button @click="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white bg-black/50 p-2 rounded-full hover:bg-black/70">
          ‹
        </button>
        <button @click="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white bg-black/50 p-2 rounded-full hover:bg-black/70">
          ›
        </button>
      </section>

      <!-- About / Intro -->
      <section id="about" class="px-6 py-16 bg-white">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-center">
          <div class="space-y-4">
            <h2 class="text-3xl font-bold">Introducing<br />The Barber Shop Since 1991</h2>
            <img src="/images/templates/barbershop/service-shave.png" alt="Icon" class="h-16 w-16" />
            <p class="text-gray-700 leading-relaxed">
              Barber is a person whose occupation is mainly to cut dress groom style and shave men’s and boys’ hair. A barber is a person who feels to look good and give a look.
            </p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <img src="/images/templates/barbershop/barbershop-interior.jpg" class="rounded-lg shadow-lg object-cover w-full h-40" />
            <img src="/images/templates/barbershop/barber-cutting.jpg" class="rounded-lg shadow-lg object-cover w-full h-40" />
            <img src="/images/templates/barbershop/close-up-man-getting-groomed.jpg" class="rounded-lg shadow-lg object-cover w-full h-40" />
            <img src="/images/templates/barbershop/blog-4-1000x731.jpg" class="rounded-lg shadow-lg object-cover w-full h-40" />
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section id="services" class="px-6 py-16 bg-[#0D1317] text-white">
        <h2 class="text-3xl font-bold text-center mb-8">Our Services</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="(s,i) in services" :key="i" class="space-y-2 text-center">
            <img :src="s.image" alt="" class="mx-auto h-32 w-32 object-cover rounded-lg border-2 border-[#A5683E] p-1" />
            <p class="uppercase text-sm tracking-wide">{{ s.name }}</p>
          </div>
        </div>
      </section>

      <!-- Footer CTA -->
      <section class="px-6 py-16 bg-black text-white text-center">
        <h2 class="text-4xl font-bold mb-4">Experience the Art of Barbering</h2>
        <button class="bg-[#A5683E] px-6 py-3 rounded hover:bg-opacity-90 transition">Book Your Appointment</button>
        <p class="text-xs text-gray-500 mt-4">Included Built-in Form</p>
      </section>

      <!-- Footer -->
      <footer class="px-6 py-6 bg-black text-gray-400 text-center text-sm">
        <p>© 2025 Barbershop HTML5 Template. All rights reserved.</p>
      </footer>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const slides = [
  {
    title: 'Make Your Own Style',
    subtitle: 'Established with a passion for the art of barbering, we create an atmosphere that feels like home.',
    image: '/images/templates/barbershop/barber-cutting.jpg',
    cta: 'Book Now'
  },
  {
    title: 'Where Men Want to Look Their Very Best',
    subtitle: 'Our barbershop is the territory created purely for males who appreciate premium quality, time and flawless look.',
    image: '/images/templates/barbershop/barbershop-interior.jpg',
    cta: 'Make Appointment'
  }
]
const currentSlide = ref(0)
const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.length
}
const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length
}
onMounted(() => {
  setInterval(nextSlide, 5000)
})

const services = [
  { name: 'Haircuts', image: '/images/templates/barbershop/service-haircut.png' },
  { name: 'Beard', image: '/images/templates/barbershop/service-shave.png' },
  { name: 'Shaving', image: '/images/templates/barbershop/service-shave.webp' },
  { name: 'Razor Blade', image: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' }
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
