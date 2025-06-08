<template>
  <div class="bg-[#f3e8dc] text-[#2c1e16] font-sans">
    <!-- Cabeçalho -->
    <header class="bg-[#3b2c25] text-white px-6 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m2 0a2 2 0 100-4 2 2 0 000 4zM6 8a2 2 0 110-4 2 2 0 010 4zM6 16a2 2 0 100 4 2 2 0 000-4zM18 16a2 2 0 110 4 2 2 0 010-4z" />
        </svg>
        <span>BARBEARIA</span>
      </div>
      <nav class="flex gap-6 items-center text-sm">
        <a href="#" class="hover:text-[#e5c9a4]">Início</a>
        <a href="#about" class="hover:text-[#e5c9a4]">Sobre</a>
        <a href="#services" class="hover:text-[#e5c9a4]">Serviços</a>
        <a href="#contact" class="hover:text-[#e5c9a4]">Contato</a>
        <button class="bg-white text-[#3b2c25] font-semibold px-4 py-2 rounded hover:bg-[#e5c9a4] transition">Começar agora</button>
      </nav>
    </header>

    <!-- Seção Principal -->
    <section class="grid md:grid-cols-2 items-center px-6 py-20 gap-8">
      <div class="space-y-6">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight">
          Cuide do seu<br />cabelo e da sua barba
        </h1>
        <p class="text-lg">
          Ajudamos você a ter o melhor visual. Nossa barbearia é dedicada a oferecer a melhor experiência em cuidados pessoais.
        </p>
        <button class="bg-[#3b2c25] text-white px-6 py-3 rounded hover:bg-[#5a4335] transition">Começar agora</button>
      </div>
      <div>
        <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Barbeiro cortando cabelo" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </div>
    </section>

    <!-- Sobre Nós -->
    <section id="about" class="bg-[#fdf6f0] px-6 py-20 grid md:grid-cols-2 items-center gap-8">
      <div class="space-y-6">
        <h2 class="text-3xl font-bold">Sobre Nós</h2>
        <p>Somos uma barbearia que atende clientes há mais de 20 anos. Nossa equipe de barbeiros qualificados está aqui para oferecer os melhores serviços de cuidados pessoais.</p>
      </div>
      <div>
        <img src="/images/templates/barbershop/service-haircut.jpg" alt="Ferramentas de barbeiro" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </div>
    </section>

    <!-- Serviços -->
    <section id="services" class="text-center px-6 py-20">
      <h2 class="text-3xl font-bold mb-12">Serviços</h2>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-haircut.png" alt="Corte de Cabelo" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Cortes de Cabelo</h3>
          <p>Cortes profissionais adaptados ao seu estilo.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-shave.png" alt="Aparar Barba" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Aparar Barba</h3>
          <p>Aparos e modelagens profissionais para um visual elegante.</p>
        </div>
        <div class="space-y-4">
          <img src="/images/templates/barbershop/service-shave.webp" alt="Barbear" class="h-16 mx-auto" />
          <h3 class="text-xl font-semibold">Barbear</h3>
          <p>Barbear tradicional com acabamento suave.</p>
        </div>
      </div>
    </section>

    <!-- Contato -->
    <section id="contact" class="relative px-6 py-24 text-center text-white bg-cover bg-center"
      style="background-image: url('/images/templates/barbershop/barbershop-interior.jpg')">
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 space-y-6">
        <h2 class="text-4xl font-bold">Fale Conosco</h2>
        <button class="bg-white text-[#3b2c25] px-6 py-3 rounded font-bold hover:bg-[#e5c9a4] transition">Entrar em Contato</button>
      </div>
    </section>
  </div>
</template>

<script setup>
// Nenhuma lógica JS necessária por enquanto
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
