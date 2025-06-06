<template>
  <div class="bg-[#f3e8dc] text-[#2c1e16] font-sans">
    <!-- Header -->
    <header class="bg-[#3b2c25] text-white px-6 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m2 0a2 2 0 100-4 2 2 0 000 4zM6 8a2 2 0 110-4 2 2 0 010 4zM6 16a2 2 0 100 4 2 2 0 000-4zM18 16a2 2 0 110 4 2 2 0 010-4z" />
        </svg>
        <span>BARBERSHOP</span>
      </div>
      <nav class="flex gap-6 items-center text-sm">
        <a href="#" class="hover:text-[#e5c9a4]">Home</a>
        <a href="#about" class="hover:text-[#e5c9a4]">About</a>
        <a href="#services" class="hover:text-[#e5c9a4]">Services</a>
        <a href="#contact" class="hover:text-[#e5c9a4]">Contact</a>
        <button class="bg-white text-[#3b2c25] font-semibold px-4 py-2 rounded hover:bg-[#e5c9a4] transition">Get Started</button>
      </nav>
    </header>

    <!-- Hero -->
    <section class="grid md:grid-cols-2 items-center px-6 py-20 gap-8">
      <div class="space-y-6">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight">
          Take care of your<br />hair and beard
        </h1>
        <p class="text-lg">
          We help you to have the best hair and beard. Our barbershop is dedicated to providing best grooming experience.
        </p>
        <button class="bg-[#3b2c25] text-white px-6 py-3 rounded hover:bg-[#5a4335] transition">Get Started</button>
      </div>
      <div>
        <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Barber cutting hair" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </div>
    </section>

    <!-- About Us -->
    <section id="about" class="bg-[#fdf6f0] px-6 py-20 grid md:grid-cols-2 items-center gap-8">
      <div class="space-y-6">
        <h2 class="text-3xl font-bold">About Us</h2>
        <p>We are a barbershop that has been serving our customers for over 20 years. Our team of skilled barbers is here to provide you with the finest grooming services.</p>
      </div>
      <div>
        <img src="/images/templates/barbershop/barber-tools.jpg" alt="Barber tools" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </div>
    </section>

    <!-- Services -->
    <section id="services" class="text-center px-6 py-20">
      <h2 class="text-3xl font-bold mb-12">Services</h2>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-haircut.png" alt="Haircut" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Haircuts</h3>
          <p>Professional haircuts tailored to your style.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-beard.png" alt="Beard Trim" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Beard Trimming</h3>
          <p>Expert trimming and shaping for a polished look.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-shave.png" alt="Shaves" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Shaves</h3>
          <p>Traditional shaves with a smooth finish.</p>
        </div>
      </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="relative px-6 py-24 text-center text-white bg-cover bg-center"
      style="background-image: url('/images/templates/barbershop/barbershop-interior.jpg')">
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 space-y-6">
        <h2 class="text-4xl font-bold">Contact Us</h2>
        <button class="bg-white text-[#3b2c25] px-6 py-3 rounded font-bold hover:bg-[#e5c9a4] transition">Get in Touch</button>
      </div>
    </section>
  </div>
</template>

<script setup>
// No JS logic needed for now
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
