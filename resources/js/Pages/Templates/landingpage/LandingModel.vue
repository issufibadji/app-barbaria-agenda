<template>
  <div class="font-sans scroll-smooth">
    <!-- Navbar -->
    <header class="fixed w-full bg-white z-50 shadow px-6 py-4 flex items-center justify-between">
      <div class="text-2xl font-bold">Logo</div>
      <button class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <nav class="hidden md:flex space-x-6 text-sm uppercase text-gray-700">
        <a href="#hero" class="hover:text-gray-900">Início</a>
        <a href="#servicos" class="hover:text-gray-900">Serviços</a>
        <a href="#quem" class="hover:text-gray-900">Quem Somos</a>
        <a href="#barbeiros" class="hover:text-gray-900">Barbeiros</a>
        <a href="#contato" class="hover:text-gray-900">Contato</a>
      </nav>
    </header>

    <main class="pt-20">
      <!-- Hero -->
      <section id="hero" class="relative bg-[#0D1317] h-[500px] flex items-center justify-center">
        <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Hero" class="absolute inset-0 w-full h-full object-cover opacity-80" />
        <div class="relative z-10 max-w-lg p-6 border-2 border-[#7FAE9E] text-white">
          <h1 class="text-3xl font-bold mb-4">A melhor barbearia</h1>
          <p class="text-sm mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi.</p>
          <button class="px-4 py-2 border border-white hover:bg-white hover:text-black transition">Marcar um horário</button>
        </div>
        <p class="absolute bottom-4 right-4 text-gray-400 text-xs">Imagem de Freepik</p>
      </section>

      <!-- Nossos serviços -->
      <section id="servicos" class="px-6 py-16 bg-white">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos serviços</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="(s,i) in servicos" :key="i" class="text-center">
            <img :src="s.imagem" alt="" class="mx-auto rounded-lg mb-4 w-40 h-40 object-cover" />
            <h3 class="font-semibold mb-2">{{ s.nome }}</h3>
            <p class="text-gray-600 text-sm">{{ s.preco }}</p>
          </div>
        </div>
        <p class="text-center text-gray-400 text-xs mt-8">Imagem de Freepik</p>
      </section>

      <!-- Quem somos -->
      <section id="quem" class="px-6 py-16 bg-[#B0A78B] text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6 items-center">
          <div class="rounded-lg overflow-hidden shadow-lg">
            <img src="/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg" alt="" class="w-full h-80 object-cover" />
          </div>
          <div class="p-6 bg-white bg-opacity-20 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Melhor corte de cabelo e barba em Nova York</h2>
            <p class="text-sm leading-relaxed mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis tortor eget elit vehicula venenatis.</p>
            <p class="text-xs text-gray-100">Imagem de Freepik</p>
            <button class="mt-6 px-4 py-2 bg-[#0D1317] text-white rounded">Marcar um horário</button>
          </div>
        </div>
      </section>

      <!-- Bem-vindo -->
      <section class="px-6 py-16 bg-black text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6 items-center">
          <div class="order-2 md:order-1">
            <h2 class="text-2xl font-bold mb-4">Bem-vindo à barbearia</h2>
            <p class="text-sm leading-relaxed mb-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <p class="text-xs text-gray-400">Imagem de Freepik</p>
          </div>
          <div class="order-1 md:order-2">
            <img src="/images/templates/barbershop/barber.jpg" alt="" class="w-full h-80 object-cover rounded-lg shadow-lg" />
          </div>
        </div>
      </section>

      <!-- Nossos barbeiros -->
      <section id="barbeiros" class="px-6 py-16 bg-white">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos barbeiros</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div v-for="(b,i) in barbeiros" :key="i" class="bg-gray-100 p-6 rounded-lg text-center">
            <img :src="b.imagem" alt="" class="w-32 h-32 object-cover rounded-full mx-auto mb-4" />
            <h3 class="font-semibold mb-1">{{ b.nome }}</h3>
            <p class="text-gray-500 text-xs mb-2">Barbeiro</p>
            <div class="flex justify-center space-x-2">
              <a v-for="icon in b.icons" :key="icon" href="#" class="text-gray-600 hover:text-black">
                <img :src="icon" class="h-4 w-4" />
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Horário & Porque escolher -->
      <section class="px-6 py-16 bg-white text-black">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-6">
          <div class="bg-white p-6 shadow-md rounded-lg">
            <h3 class="font-semibold mb-4">Horário de trabalho</h3>
            <ul class="text-sm space-y-1">
              <li>Domingo: 10h00 às 17h00</li>
              <li>Segunda - Sexta: 09h00 às 20h00</li>
              <li>Quarta: 20h00 às 23h00</li>
              <li>Quinta: 20h00 às 23h00</li>
              <li>Sexta: 10h00 às 20h00</li>
              <li>Sábado: 10h00 às 20h00</li>
            </ul>
          </div>
          <div class="space-y-4">
            <h3 class="font-semibold">Porque escolher-nos?</h3>
            <ul class="list-disc list-inside text-sm leading-relaxed">
              <li>Equipe profissional e experiente</li>
              <li>Ambiente acolhedor</li>
              <li>Produtos premium</li>
              <li>Localização central</li>
              <li>Serviço personalizado</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Nossos preços -->
      <section id="precos" class="px-6 py-16 bg-white text-black">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos preços</h2>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-4 text-sm">
          <div v-for="(p, i) in prices" :key="i" class="flex justify-between">
            <span>{{ p.title }}</span>
            <span class="font-semibold">{{ p.price }}</span>
          </div>
        </div>
        <p class="text-center text-gray-400 text-xs mt-4">Imagem de Freepik</p>
      </section>

      <!-- Destaque -->
      <section class="px-6 py-16 bg-white text-black text-center">
        <div class="max-w-4xl mx-auto bg-gray-100 p-6 rounded-lg shadow-md inline-block">
          <h3 class="font-semibold mb-4">Cortes de cabelo de alta qualidade, barbeados com navalha e bebidas</h3>
          <button class="mt-2 px-4 py-2 bg-black text-white rounded">+1 (777) 787 87 78</button>
        </div>
      </section>

      <!-- Testemunhos -->
      <section class="px-6 py-16 bg-white text-black">
        <h2 class="text-3xl font-bold text-center mb-8">Testemunhos</h2>
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6">
          <div v-for="(t,i) in testimonials" :key="i" class="bg-gray-100 p-6 rounded-lg text-center">
            <img :src="t.imagem" alt="" class="w-16 h-16 object-cover rounded-full mx-auto mb-4" />
            <p class="italic mb-2">“{{ t.text }}”</p>
            <p class="font-semibold">{{ t.author }}</p>
          </div>
        </div>
      </section>

      <!-- Contato -->
      <section id="contato" class="px-6 py-16 bg-white text-black">
        <h2 class="text-3xl font-bold text-center mb-8">Contate-nos</h2>
        <form class="max-w-4xl mx-auto space-y-4">
          <input type="text" placeholder="Seu nome" class="w-full px-4 py-2 rounded bg-gray-200" />
          <input type="email" placeholder="Seu e-mail" class="w-full px-4 py-2 rounded bg-gray-200" />
          <textarea rows="4" placeholder="Sua mensagem" class="w-full px-4 py-2 rounded bg-gray-200"></textarea>
          <button type="submit" class="bg-black text-white px-6 py-3 rounded">Enviar</button>
        </form>
        <p class="text-center text-gray-400 text-xs mt-4">Imagem de Freepik</p>
      </section>
    </main>
  </div>
</template>

<script setup>
const servicos = [
  { nome: 'Cortes de cabelo', preco: 'US$ 35 ou mais', imagem: '/images/templates/barbershop/barber-cutting.jpg' },
  { nome: 'Pão e mais', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' },
  { nome: 'Barbear', preco: 'US$ 30 ou mais', imagem: '/images/templates/barbershop/service-shave.png' },
  { nome: 'Lâmina de barbear', preco: 'US$ 45 ou mais', imagem: '/images/templates/barbershop/service-shave.webp' },
  { nome: 'Skinfade', preco: 'US$ 35 ou mais', imagem: '/images/templates/barbershop/blog-4-1000x731.jpg' },
  { nome: 'Serviço completo', preco: 'US$ 55 ou mais', imagem: '/images/templates/barbershop/blog-8-1000x731.jpg' },
  { nome: 'Aparar barba', preco: 'US$ 30 ou mais', imagem: '/images/templates/barbershop/54634.jpg' },
  { nome: 'Corte infantil', preco: 'US$ 25 ou mais', imagem: '/images/templates/barbershop/qw.jpg' }
]

const barbeiros = [
  { nome: 'Mark Brown', imagem: '/images/templates/barbershop/maxresdefault.jpg', icons: ['/images/templates/barbershop/18785178.png'] },
  { nome: 'David Villa', imagem: '/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg', icons: ['/images/templates/barbershop/18927978.png'] },
  { nome: 'Clayton Lane', imagem: '/images/templates/barbershop/barber.jpg', icons: ['/images/templates/barbershop/18785178.png'] },
  { nome: 'Robert Reed', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg', icons: ['/images/templates/barbershop/18927978.png'] },
  { nome: 'Dan Spring', imagem: '/images/templates/barbershop/service-haircut.png', icons: ['/images/templates/barbershop/18785178.png'] },
  { nome: 'Dwight Nelson', imagem: '/images/templates/barbershop/blog-4-1000x731.jpg', icons: ['/images/templates/barbershop/18927978.png'] }
]

const prices = [
  { title: 'Corte de cabelo normal', price: '$34+' },
  { title: 'Barbear real', price: '$35+' },
  { title: 'Corte de cabelo + barba real', price: '$60+' },
  { title: 'Corte de cabelo + aparar barba', price: '$65+' },
  { title: 'Máquina de aparar barba', price: '$55+' },
  { title: 'Barba + Facial', price: '$55+' },
  { title: 'Facial Masculino', price: '$25+' }
]

const testimonials = [
  { text: 'Ótimo atendimento e corte impecável.', author: 'Anna Larson', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' },
  { text: 'Ambiente agradável e barbeiros profissionais.', author: 'Johnathon King', imagem: '/images/templates/barbershop/barber.jpg' },
  { text: 'Recomendo a todos!', author: 'Mike Pearson', imagem: '/images/templates/barbershop/blog-8-1000x731.jpg' }
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
