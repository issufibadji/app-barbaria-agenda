<template>
  <div class="bg-black text-white font-sans">
    <!-- Header -->
    <header class="flex justify-between items-center px-6 py-4 bg-black border-b border-gray-800">
      <div class="text-2xl font-bold">BARBER</div>
      <nav class="flex gap-6 items-center text-sm uppercase">
        <a href="#" class="hover:text-yellow-400">Início</a>
        <a href="#servicos" class="hover:text-yellow-400">Serviços</a>
        <a href="#beneficios" class="hover:text-yellow-400">Benefícios</a>
        <a href="#contato" class="hover:text-yellow-400">Contato</a>
        <button class="bg-yellow-600 text-black font-semibold px-4 py-2 rounded hover:bg-yellow-300 transition">
          Agende uma consulta
        </button>
      </nav>
    </header>

    <!-- Hero -->
    <section
      class="relative bg-cover bg-center h-[500px]"
      style="background-image: url('/images/templates/barbershop/barber-cutting.jpg')"
    >
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-white leading-snug">
          O que fazemos<br />
          <span class="text-yellow-400">NOSSOS SERVIÇOS</span>
        </h1>
        <button class="mt-6 bg-yellow-600 text-black px-6 py-3 font-semibold rounded hover:bg-yellow-300 transition">
          Agende uma consulta
        </button>
      </div>
    </section>

    <!-- Serviços de barbearia (imagem + 2×2 ícones dourados) -->
    <section id="servicos" class="py-16 px-6 bg-zinc-900 text-center text-white">
      <h2 class="text-3xl font-bold mb-4">Serviços de barbearia</h2>
      <p class="text-gray-400 mb-12 max-w-xl mx-auto">
        Selecionamos os melhores serviços para que você tenha uma experiência única de cuidados pessoais.
      </p>

      <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto items-center">
        <!-- Imagem Grande -->
        <div>
          <img
            src="/images/templates/barbershop/barber.jpg"
            alt="Barbeiro em ação"
            class="rounded-lg shadow-lg w-full h-auto object-cover"
          />
        </div>
        <!-- Grade 2×2 -->
        <div class="grid grid-cols-2 gap-6">
          <div
            class="bg-yellow-600 text-black p-6 rounded-lg hover:bg-yellow-300 transition cursor-pointer flex flex-col items-center"
          >
            <img src="/images/templates/barbershop/service-haircut.png" alt="Corte de cabelo" class="h-12 mb-4" />
            <h3 class="font-bold">Corte de cabelo</h3>
          </div>
          <div
            class="bg-yellow-600 text-black p-6 rounded-lg hover:bg-yellow-300 transition cursor-pointer flex flex-col items-center"
          >
            <img src="/images/templates/barbershop/service-shave.png" alt="Barbear" class="h-12 mb-4" />
            <h3 class="font-bold">Barbear</h3>
          </div>
          <div
            class="bg-yellow-600 text-black p-6 rounded-lg hover:bg-yellow-300 transition cursor-pointer flex flex-col items-center"
          >
            <img src="/images/templates/barbershop/service-shave.webp" alt="Aparar barba" class="h-12 mb-4" />
            <h3 class="font-bold">Aparar barba</h3>
          </div>
          <div
            class="bg-yellow-600 text-black p-6 rounded-lg hover:bg-yellow-300 transition cursor-pointer flex flex-col items-center"
          >
            <img src="/images/templates/barbershop/service-haircut.png" alt="Corte infantil" class="h-12 mb-4" />
            <h3 class="font-bold">Corte infantil</h3>
          </div>
        </div>
      </div>
      <p class="mt-6 text-gray-500 text-sm">Imagem de Freepik</p>
    </section>

    <!-- Nossos Serviços (8 cards) -->
    <section class="bg-black px-6 py-16 text-center text-white">
      <h2 class="text-3xl font-bold mb-12">Nossos Serviços</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
        <div v-for="(s, i) in servicos" :key="i" class="space-y-2">
          <img :src="s.imagem" :alt="s.nome" class="rounded-lg w-full h-40 object-cover" />
          <h3 class="font-semibold">{{ s.nome }}</h3>
          <p class="text-yellow-400">{{ s.preco }}</p>
        </div>
      </div>
      <p class="mt-4 text-gray-500 text-sm">Imagens de Freepik</p>
    </section>

    <!-- Benefícios (3 colunas) -->
    <section id="beneficios" class="bg-zinc-900 px-6 py-16 text-center text-white">
      <h2 class="text-3xl font-bold mb-12">Nossos Benefícios</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <div v-for="(b, i) in beneficios" :key="i" class="space-y-2">
          <img :src="b.imagem" :alt="b.titulo" class="rounded-lg w-full h-40 object-cover" />
          <h3 class="font-semibold">{{ b.titulo }}</h3>
        </div>
      </div>
      <p class="mt-4 text-gray-500 text-sm">Imagens de Freepik</p>
    </section>

    <!-- Rodapé -->
    <footer id="contato" class="bg-black px-6 py-12 border-t border-gray-800">
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
        <!-- Logo -->
        <div>
          <h3 class="text-xl font-bold">BARBER</h3>
          <img
            src="/images/templates/barbershop/barber-shop-logo.jpg"
            alt="Logo Barber"
            class="mt-2 w-24 h-auto"
          />
        </div>
        <!-- Contato -->
        <div class="space-y-1">
          <p class="text-gray-400">17 Green St, New Town, XY</p>
          <p class="text-gray-400">contato@barber.com</p>
          <p class="text-gray-400">(11) 99999-9999</p>
        </div>
        <!-- WhatsApp -->
        <div class="flex items-center justify-center md:justify-end gap-3">
          <img src="/images/templates/barbershop/18785178.png" alt="WhatsApp" class="w-8 h-8" />
          <a href="https://wa.me/559999999999" class="text-green-500 font-semibold hover:underline">
            Chame no WhatsApp
          </a>
        </div>
      </div>
      <p class="text-gray-500 text-sm text-center mt-6">
        &copy; 2025 Barbearia. Todos os direitos reservados.
      </p>
    </footer>
  </div>
</template>

<script setup>
const servicos = [
  { nome: 'Cortes de cabelo', preco: 'US$ 35 ou mais', imagem: '/images/templates/barbershop/54634.jpg' },
  { nome: 'Pão e mais', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/e213.jpg' },
  { nome: 'Barbear', preco: 'US$ 30 ou mais', imagem: '/images/templates/barbershop/e213.jpg' },
  { nome: 'Lâmina de barbear', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' },
  { nome: 'Desbastamento de pele', preco: 'US$ 35 ou mais', imagem: '/images/templates/barbershop/blog-4-1000x731.jpg' },
  { nome: 'Serviço completo', preco: 'US$ 55 ou mais', imagem: '/images/templates/barbershop/blog-8-1000x731.jpg' },
  { nome: 'Aparar barba', preco: 'US$ 30 ou mais', imagem: '/images/templates/barbershop/barber-cutting.jpg' },
  { nome: 'Corte infantil', preco: 'US$ 25 ou mais', imagem: '/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg' },
]

const beneficios = [
  { titulo: 'Produtos de Qualidade', imagem: '/images/templates/barbershop/ffff.jpg' },
  { titulo: 'Equipamentos de Qualidade', imagem: '/images/templates/barbershop/images.png' },
  { titulo: 'Barbeiros Profissionais', imagem: '/images/templates/barbershop/maxresdefault.jpg' },
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
