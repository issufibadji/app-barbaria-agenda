<template>
  <div class="bg-black text-white font-sans">
    <!-- Header -->
    <header class="flex justify-between items-center px-6 py-4 bg-black border-b border-gray-800">
      <div class="text-2xl font-bold text-white">BARBER</div>
      <nav class="flex gap-6 items-center text-sm uppercase">
        <a href="#" class="hover:text-yellow-400">Início</a>
        <a href="#servicos" class="hover:text-yellow-400">Serviços</a>
        <a href="#beneficios" class="hover:text-yellow-400">Benefícios</a>
        <a href="#contato" class="hover:text-yellow-400">Contato</a>
        <button class="bg-yellow-400 text-black font-semibold px-4 py-2 rounded hover:bg-yellow-300 transition">
          Agende uma consulta
        </button>
      </nav>
    </header>

    <!-- Hero -->
    <section class="relative bg-cover bg-center h-[500px] flex items-center justify-center text-center"
      style="background-image: url('/images/templates/barbershop/barber-cutting.jpg');">
      <div class="absolute inset-0 bg-black bg-opacity-60"></div>
      <div class="relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">O que fazemos<br><span class="text-yellow-400">NOSSOS SERVIÇOS</span></h1>
        <button class="bg-yellow-400 text-black px-6 py-3 font-semibold rounded hover:bg-yellow-300 transition">Agende uma consulta</button>
      </div>
    </section>

    <!-- Serviços de barbearia -->
    <section id="servicos" class="py-16 px-6 bg-zinc-900 text-center">
      <h2 class="text-3xl font-bold mb-4">Serviços de barbearia</h2>
      <p class="text-gray-400 mb-12">Selecionamos os melhores serviços para que você tenha uma experiência única de cuidados pessoais.</p>
      <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        <div class="bg-zinc-800 p-6 rounded hover:bg-yellow-400 hover:text-black transition">
          <h3 class="text-xl font-semibold mb-2">Corte de cabelo</h3>
          <p>Clássico ou moderno</p>
        </div>
        <div class="bg-zinc-800 p-6 rounded hover:bg-yellow-400 hover:text-black transition">
          <h3 class="text-xl font-semibold mb-2">Barbear</h3>
          <p>Acabamento profissional</p>
        </div>
        <div class="bg-zinc-800 p-6 rounded hover:bg-yellow-400 hover:text-black transition">
          <h3 class="text-xl font-semibold mb-2">Aparar barba</h3>
          <p>Design e alinhamento</p>
        </div>
      </div>
    </section>

    <!-- Lista de Serviços com imagens -->
    <section class="bg-black px-6 py-16 text-center">
      <h2 class="text-3xl font-bold mb-12">Nossos Serviços</h2>
      <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
        <div v-for="(servico, index) in servicos" :key="index">
          <img :src="servico.imagem" class="rounded-lg mb-2 w-full h-40 object-cover" :alt="servico.nome" />
          <h3 class="font-semibold">{{ servico.nome }}</h3>
          <p class="text-yellow-400">{{ servico.preco }}</p>
        </div>
      </div>
    </section>

    <!-- Benefícios -->
    <section id="beneficios" class="bg-zinc-900 px-6 py-16 text-center">
      <h2 class="text-3xl font-bold mb-12">Nossos Benefícios</h2>
      <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <div v-for="(beneficio, index) in beneficios" :key="index">
          <img :src="beneficio.imagem" class="rounded-lg mb-4 w-full h-40 object-cover" :alt="beneficio.titulo" />
          <h3 class="font-semibold">{{ beneficio.titulo }}</h3>
        </div>
      </div>
    </section>

    <!-- Rodapé -->
    <footer id="contato" class="bg-black px-6 py-12 text-center border-t border-gray-800">
      <div class="mb-6">
        <h3 class="text-xl font-bold">BARBER</h3>
        <p class="text-gray-400">Localização: Av. Exemplo, 123 – Centro</p>
        <p class="text-gray-400">Telefone: (11) 99999-9999</p>
        <p class="text-gray-400">Email: contato@barber.com</p>
      </div>
      <p class="text-gray-500 text-sm">&copy; 2025 Barbearia. Todos os direitos reservados.</p>
    </footer>
  </div>
</template>

<script setup>
const servicos = [
  { nome: 'Cortes de cabelo', preco: 'US$ 35 ou mais', imagem: '/images/templates/barbershop/ffff.jpg' },
  { nome: 'Pão e mais', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' },
  { nome: 'Barbear', preco: 'US$ 30 ou mais', imagem: '/images/templates/barbershop/kjkk.jpg' },
  { nome: 'Lâmina de barbear', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/e213.jpg' }
]

const beneficios = [
  { titulo: 'Produtos de Qualidade', imagem: '/images/templates/barbershop/blog-4-1000x731.jpg' },
  { titulo: 'Equipamentos de Qualidade', imagem: '/images/templates/barbershop/images.png' },
  { titulo: 'Barbeiros Profissionais', imagem: '/images/templates/barbershop/qw.jpg' }
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
