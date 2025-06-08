<template>
  <div class="font-sans scroll-smooth bg-black text-white">
    <!-- Navbar -->
    <header class="fixed w-full top-0 left-0 z-50 bg-transparent px-6 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <img src="/images/templates/barbershop/18785178.png" alt="Logo" class="h-6 w-6" />
        <span class="uppercase text-yellow-500 text-sm tracking-widest">YourLogo</span>
      </div>
      <nav class="hidden md:flex space-x-8 uppercase text-xs">
        <a href="#" class="hover:text-yellow-500">Home</a>
        <a href="#about" class="hover:text-yellow-500">About</a>
        <a href="#blog" class="hover:text-yellow-500">Blog</a>
        <a href="#contact" class="hover:text-yellow-500">Contact</a>
        <a href="#gallery" class="hover:text-yellow-500">Gallery</a>
      </nav>
      <button class="hidden md:inline-block bg-yellow-500 text-black px-4 py-2 text-xs uppercase rounded hover:bg-yellow-600 transition">
        Book Appointment
      </button>
      <button class="md:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </header>

    <main class="pt-16">
      <!-- Hero Section -->
      <section class="relative bg-[url('/images/templates/barbershop/barbershop-interior.jpg')] bg-cover bg-center h-[600px] flex items-center">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 max-w-6xl mx-auto grid md:grid-cols-2 items-center gap-8 px-6">

          <!-- Left Image with Decor -->
          <div class="relative">
            <div class="absolute -left-6 top-1/2 w-10 h-1 bg-yellow-500"></div>
            <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-6 w-1 h-10 bg-yellow-500"></div>
            <img
              src="/images/templates/barbershop/barber.jpg"
              alt="Barber Portrait"
              class="border-4 border-yellow-500 rounded-lg filter grayscale mx-auto"
            />
            <!-- Circular Text -->
            <div class="absolute top-4 right-4 w-24 h-24 flex items-center justify-center">
              <span class="text-[9px] uppercase">
                Just sit back <br />and enjoy
              </span>
            </div>
          </div>

          <!-- Right Content -->
          <div class="space-y-6 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-widest">
              The Barber's <br />House
            </h1>
            <h2 class="text-yellow-500 text-lg uppercase tracking-wider">
              Authentic Style
            </h2>
            <p class="max-w-md mx-auto md:mx-0 text-sm leading-relaxed">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit
              tempor incididunt dolor sit consecte adip amet.
            </p>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
              <button class="bg-yellow-500 text-black px-6 py-2 uppercase text-xs rounded hover:bg-yellow-600 transition">
                Book Appointment
              </button>
              <a href="#gallery" class="uppercase text-yellow-500 text-xs hover:underline">
                Gallery
              </a>
            </div>
          </div>

          <!-- Social Icons -->
          <div class="hidden md:flex flex-col items-center space-y-4 absolute right-8 top-1/3">
            <a href="#" class="text-yellow-500 hover:text-white"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-yellow-500 hover:text-white"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-yellow-500 hover:text-white"><i class="fab fa-twitter"></i></a>
          </div>

        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
// Sem lógica adicional por enquanto
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
