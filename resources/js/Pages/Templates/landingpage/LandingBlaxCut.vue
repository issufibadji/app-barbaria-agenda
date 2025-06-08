<template>
  <div class="font-sans scroll-smooth">
    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full z-50 bg-transparent px-6 py-4 flex items-center justify-between">
      <div class="flex items-center text-white text-xl font-bold">
        <span>BLA</span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg><span>CUT</span>
      </div>
      <nav class="hidden md:flex space-x-6 text-white text-sm uppercase">
        <a href="#" class="hover:text-[#A5683E]">Home</a>
        <a href="#services" class="hover:text-[#A5683E]">Services</a>
        <a href="#about" class="hover:text-[#A5683E]">About</a>
        <a href="#book" class="hover:text-[#A5683E]">Book Now</a>
        <a href="#blog" class="hover:text-[#A5683E]">Blog</a>
        <a href="#extras" class="hover:text-[#A5683E]">Extras</a>
      </nav>
      <button class="hidden md:inline-block bg-[#A5683E] text-white px-4 py-2 rounded hover:bg-opacity-80 transition">Book Now</button>
      <button class="md:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </header>

    <main class="pt-16 bg-black">
      <!-- Hero -->
      <section class="relative h-[600px] bg-cover bg-center" style="background-image: url('/images/templates/barbershop/barber-cutting.jpg')">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
          <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">Make Your Own Style</h1>
          <p class="text-white max-w-xl mb-6">Established with a passion for the art of barbering, we take great pride in our craft and strive to create an atmosphere that feels like home.</p>
          <button class="bg-[#A5683E] text-white px-6 py-3 rounded hover:bg-opacity-80 transition">Book Now</button>
        </div>
      </section>

      <!-- Our Services -->
      <section id="services" class="px-6 py-16 bg-[#0D1317] text-white">
        <h2 class="text-3xl font-bold text-center mb-8">Our Services</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="(s,i) in services" :key="i" class="space-y-2 text-center">
            <img :src="s.image" alt="" class="mx-auto w-32 h-32 object-cover rounded-lg border-2 border-[#A5683E] p-1" />
            <p class="uppercase text-sm tracking-wider">{{ s.label }}</p>
          </div>
        </div>
      </section>

      <!-- Trending Styles -->
      <section class="px-6 py-16 bg-black text-white">
        <h2 class="text-3xl font-bold text-center mb-8">Trending Styles</h2>
        <div class="overflow-x-auto">
          <div class="flex space-x-6 px-6">
            <img v-for="(t,i) in trending" :key="i" :src="t" class="w-64 h-64 object-cover rounded-lg shadow-lg" />
          </div>
        </div>
      </section>

      <!-- Included Form Badge -->
      <div class="relative">
        <div class="absolute top-[-60px] right-6 w-40 h-40 bg-white rounded-full flex items-center justify-center shadow-lg">
          <span class="text-[#A5683E] font-bold text-center">Included<br/>Built In Form</span>
        </div>
      </div>

      <!-- Hours & Location -->
      <section class="px-6 py-16 bg-[#0D1317] text-white">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
          <div class="space-y-4">
            <h3 class="font-semibold uppercase">We are open</h3>
            <ul class="space-y-2 text-sm">
              <li v-for="(h,i) in hours" :key="i">{{ h.day }}: {{ h.time }}</li>
            </ul>
          </div>
          <div class="space-y-4">
            <h3 class="font-semibold uppercase">Location</h3>
            <p class="text-sm">{{ location.address }}</p>
            <p class="text-sm">Phone: {{ location.phone }}</p>
            <p class="text-sm">Email: {{ location.email }}</p>
          </div>
        </div>
      </section>

      <!-- Footer CTA -->
      <section class="px-6 py-16 bg-black text-white text-center">
        <h2 class="text-4xl font-bold mb-4">Trim — Hair Color</h2>
        <div class="space-x-4">
          <button class="bg-[#A5683E] px-6 py-3 rounded">Book Now</button>
          <button class="border border-white px-6 py-3 rounded hover:bg-white hover:text-black transition">Learn More</button>
        </div>
      </section>

      <!-- Footer -->
      <footer class="px-6 py-6 bg-black text-gray-400 text-sm text-center">
        <div class="flex justify-center space-x-4 mb-4">
          <a href="#">Facebook</a>
          <a href="#">Instagram</a>
          <a href="#">Twitter</a>
        </div>
        <p>Copyright © 2025 Blaxcut by DesignMosaic</p>
      </footer>
    </main>
  </div>
</template>

<script setup>
const services = [
  { label: 'Haircuts', image: '/images/templates/barbershop/service-haircut.png' },
  { label: 'Beard', image: '/images/templates/barbershop/service-shave.png' },
  { label: 'Shaving', image: '/images/templates/barbershop/service-shave.webp' },
  { label: 'Razor Blade', image: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' }
]
const trending = [
  '/images/templates/barbershop/blog-4-1000x731.jpg',
  '/images/templates/barbershop/blog-8-1000x731.jpg',
  '/images/templates/barbershop/barber-cutting.jpg',
  '/images/templates/barbershop/qw.jpg'
]
const hours = [
  { day: 'Mon - Thu', time: '8:00am - 6:30pm' },
  { day: 'Friday', time: '8:00am - 8:30pm' },
  { day: 'Sat - Sun', time: '9:30am - 5:30pm' }
]
const location = {
  address: '100 Mainstreet Center, NY',
  phone: '+1 333 8080 1000',
  email: 'contact@blaxcut.com'
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
