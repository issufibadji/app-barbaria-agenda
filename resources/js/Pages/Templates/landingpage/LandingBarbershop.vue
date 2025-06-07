<template>
  <div class="font-sans text-gray-800">
    <!-- Hero with background image -->
    <section class="relative h-screen flex items-center justify-center text-center text-white" style="background-image: url('/images/templates/barbershop/barbershop-interior.jpg'); background-size: cover; background-position: center;">
      <div class="absolute inset-0 bg-black/60" />
      <div class="relative z-10 space-y-6 px-4">
        <h1 class="text-5xl font-bold tracking-wide">Barbershop Style</h1>
        <p class="max-w-xl mx-auto">Premium grooming experience for modern gentlemen.</p>
        <a href="#services" class="bg-white text-gray-900 px-6 py-3 rounded font-semibold hover:bg-gray-200 transition">Explore Services</a>
      </div>
    </section>

    <!-- Services overview -->
    <section id="services" class="py-20 px-6 text-center bg-[#fdf6f0]">
      <h2 class="text-3xl font-bold mb-12">Our Services</h2>
      <div class="grid md:grid-cols-3 gap-10 max-w-5xl mx-auto">
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-haircut.png" alt="Haircut" class="h-20 mx-auto" />
          <h3 class="text-xl font-semibold">Haircuts</h3>
          <p>Modern and classic styles tailored to you.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-beard.png" alt="Beard" class="h-20 mx-auto" />
          <h3 class="text-xl font-semibold">Beard Care</h3>
          <p>Precise trimming and conditioning.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-shave.png" alt="Shave" class="h-20 mx-auto" />
          <h3 class="text-xl font-semibold">Classic Shave</h3>
          <p>Smooth finish with hot towel service.</p>
        </div>
      </div>
    </section>

    <!-- About -->
    <section class="py-20 px-6 grid md:grid-cols-2 items-center gap-8">
      <div class="space-y-6">
        <h2 class="text-3xl font-bold">About Us</h2>
        <p>With years of experience, our barbers deliver outstanding cuts and shaves in a relaxing atmosphere.</p>
      </div>
      <div>
        <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Barber cutting" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </div>
    </section>
  </div>
</template>

<script setup>
// Landing page has no reactive logic
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
