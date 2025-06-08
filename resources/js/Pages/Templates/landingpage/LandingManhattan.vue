<template>
  <!-- Root com scroll suave -->
  <div class="scroll-smooth bg-black text-white font-sans">
    <!-- Cabeçalho fixo -->
    <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 bg-black border-b border-gray-800">
      <div class="text-2xl font-bold">BARBER</div>
      <nav class="flex gap-6 items-center text-sm uppercase">
        <a href="#inicio" class="hover:text-yellow-400">Início</a>
        <a href="#sobre" class="hover:text-yellow-400">Sobre</a>
        <a href="#servicos" class="hover:text-yellow-400">Serviços</a>
        <a href="#precos" class="hover:text-yellow-400">Preços</a>
        <a href="#promocao" class="hover:text-yellow-400">Promoção</a>
        <a href="#historias" class="hover:text-yellow-400">Histórias</a>
        <a href="#contato" class="hover:text-yellow-400">Contato</a>
        <button class="ml-4 bg-yellow-400 text-black font-semibold px-4 py-2 rounded hover:bg-yellow-300 transition">
          Marque uma consulta
        </button>
      </nav>
    </header>

    <!-- Conteúdo principal com compensação do header -->
    <main class="mt-16">
      <!-- Início / Hero -->
      <section
        id="inicio"
        class="relative bg-cover bg-center h-[600px]"
        style="background-image: url('/images/templates/barbershop/barber-cutting.jpg')"
      >
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 flex flex-col items-start justify-center h-full max-w-4xl mx-auto px-6">
          <h1 class="text-5xl md:text-6xl font-bold leading-tight">
            MANHATTAN<br />
            BARBEARIA
          </h1>
          <p class="mt-4 text-lg max-w-md">
            Experiência inesquecível de preparação<br />
            em uma barbearia perto de você
          </p>
          <button class="mt-8 bg-yellow-400 text-black px-6 py-3 font-semibold rounded hover:bg-yellow-300 transition">
            Marque uma consulta
          </button>
        </div>
        <p class="absolute bottom-4 right-6 text-gray-500 text-xs">Imagem de Freepik</p>
      </section>

      <!-- Sobre -->
      <section id="sobre" class="px-6 py-16 bg-black text-center">
        <h2 class="text-3xl font-bold mb-8">Bem-vindo à melhor barbearia de Manhattan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-5xl mx-auto">
          <img src="/images/templates/barbershop/barber.jpg" alt="Barbeiro" class="rounded-lg object-cover w-full h-64" />
          <img src="/images/templates/barbershop/close-up-man-getting-groomed.jpg" alt="Barbearia" class="rounded-lg object-cover w-full h-64" />
        </div>
      </section>

      <!-- Serviços -->
      <section id="servicos" class="px-6 py-16 bg-black text-center">
        <h2 class="text-3xl font-bold mb-4">Nossos serviços</h2>
        <p class="text-gray-400 mb-12 max-w-xl mx-auto">
          Selecionamos os melhores serviços para uma experiência única.
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
          <div v-for="(icon, i) in iconsServicos" :key="i" class="flex flex-col items-center gap-2">
            <img :src="icon.src" :alt="icon.alt" class="h-12" />
            <h3 class="font-semibold">{{ icon.alt }}</h3>
          </div>
        </div>
        <p class="mt-6 text-gray-500 text-sm">Imagens de Freepik</p>
      </section>

      <!-- Preços -->
      <section id="precos" class="px-6 py-16 bg-gray-900 text-white">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos preços</h2>
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-4">
          <div v-for="(p, i) in precos" :key="i" class="flex justify-between">
            <span>{{ p.titulo }}</span>
            <span class="font-semibold">{{ p.valor }}</span>
          </div>
        </div>
      </section>

      <!-- Promoção -->
      <section id="promocao" class="px-6 py-16 bg-black text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 items-center gap-8">
          <div class="space-y-4">
            <h2 class="text-5xl font-bold">15%<br />DE DESCONTO</h2>
            <p class="text-lg">Na sua primeira consulta</p>
            <button class="mt-4 bg-yellow-400 text-black px-6 py-3 font-semibold rounded hover:bg-yellow-300 transition">
              Marque uma consulta
            </button>
          </div>
          <img src="/images/templates/barbershop/e213.jpg" alt="Promoção" class="rounded-lg object-cover w-full h-80" />
        </div>
      </section>

      <!-- Histórias -->
      <section id="historias" class="px-6 py-16 bg-gray-900 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Nossas histórias de barbearia</h2>
        <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
          A verdadeira magia do nosso trabalho está nas experiências que criamos.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
          <div v-for="(h, i) in historias" :key="i" class="bg-black p-6 rounded-lg">
            <h3 class="font-semibold mb-2">{{ h.titulo }}</h3>
            <p class="text-gray-400 text-sm">{{ h.descricao }}</p>
          </div>
        </div>
        <p class="mt-6 text-gray-500 text-sm">Imagens de Freepik</p>
      </section>

      <!-- Contato -->
      <section id="contato" class="px-6 py-16 bg-black text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Fale Conosco</h2>
        <p>Email: support@barbershop.com | WhatsApp: +1 234 56 78 90</p>
      </section>
    </main>
  </div>
</template>

<script setup>
const iconsServicos = [
  { src: '/images/templates/barbershop/service-haircut.png', alt: 'Corte de cabelo' },
  { src: '/images/templates/barbershop/service-shave.png', alt: 'Barbear' },
  { src: '/images/templates/barbershop/service-shave.webp', alt: 'Aparar barba' },
  { src: '/images/templates/barbershop/service-haircut.png', alt: 'Corte infantil' },
]

const precos = [
  { titulo: 'Corte de cabelo normal', valor: '$34+' },
  { titulo: 'Corte de cabelo + barba real', valor: '$60+' },
  { titulo: 'Barbear real', valor: '$35+' },
  { titulo: 'Corte + aparar barba', valor: '$65+' },
  { titulo: 'Corte masculino especial', valor: '$75+' },
  { titulo: 'Coloração masculina', valor: '$55+' },
  { titulo: 'Shampoo de massagem', valor: '$12+' },
  { titulo: 'Corte de cabelo longo', valor: '$55+' },
]

const historias = [
  {
    titulo: 'O barbeiro é o artista',
    descricao: 'Cada movimento é pensado para elevar seu estilo ao próximo nível.',
  },
  {
    titulo: 'Um grande barbeiro não corta apenas cabelo',
    descricao: 'Ele cria confiança, personalidade e atitude.',
  },
  {
    titulo: 'Sucesso é consequência de felicidade',
    descricao: 'A felicidade é a chave para o sucesso – e um bom corte faz parte disso.',
  },
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
