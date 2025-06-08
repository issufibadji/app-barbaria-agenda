<template>
  <div class="font-sans scroll-smooth bg-black text-white">
    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full bg-transparent z-50 px-6 py-4 flex items-center justify-between">
      <div class="text-lg font-bold">Logo</div>
      <button class="md:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <nav class="hidden md:flex space-x-8 uppercase text-sm">
        <a href="#hero" class="hover:text-gray-300">Home</a>
        <a href="#servicos" class="hover:text-gray-300">Serviços</a>
        <a href="#precos" class="hover:text-gray-300">Preços</a>
        <a href="#highlight" class="hover:text-gray-300">Destaque</a>
        <a href="#consulta" class="hover:text-gray-300">Consulta</a>
        <a href="#depoimentos" class="hover:text-gray-300">Depoimentos</a>
        <a href="#sobre" class="hover:text-gray-300">Sobre</a>
        <a href="#contato" class="px-4 py-2 bg-[#7FAE9E] text-black rounded hover:bg-[#6aa58d] transition">Reservar</a>
      </nav>
    </header>

    <main class="pt-20">
      <!-- Hero -->
      <section id="hero" class="relative bg-cover bg-center h-[500px]" style="background-image: url('/images/templates/barbershop/service-haircut.jpg')">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-center h-full px-6">
          <!-- Texto dentro de moldura -->
          <div>
            <div class="border-4 border-[#7FAE9E] p-6 max-w-sm">
              <h1 class="text-3xl font-bold mb-4">Barbearia com <br />serviço completo</h1>
              <p class="text-sm text-gray-300 mb-4">
                Amet luctus venenatis lectus magna fringilla urna porttitor rhoncus dolor. Aenean malesuada arcu non diam volutpat, eget lacinia sapien consectetur.
              </p>
              <button class="px-4 py-2 border border-white text-white uppercase text-xs hover:bg-white hover:text-black transition">Reserve um horário</button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Imagem de Freepik</p>
          </div>
          <!-- Imagem à direita -->
          <img src="/images/templates/barbershop/close-up-man-getting-groomed.jpg" alt="Serviço completo" class="rounded-lg shadow-lg w-full h-auto object-cover" />
        </div>
      </section>

      <!-- Nossos serviços -->
      <section id="servicos" class="px-6 py-16 bg-white text-black">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos serviços</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="(s,i) in servicos" :key="i" class="relative group">
            <img :src="s.imagem" alt="" class="w-full h-40 object-cover rounded-lg" />
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
              <span class="text-white font-semibold text-sm uppercase">{{ s.nome }}</span>
            </div>
          </div>
        </div>
        <p class="text-center text-gray-500 text-xs mt-6">Imagem de Freepik</p>
      </section>

      <!-- Nossos preços -->
      <section id="precos" class="px-6 py-16 bg-black">
        <h2 class="text-3xl font-bold text-center mb-8">Nossos preços</h2>
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-4 text-white text-sm">
          <div v-for="(p,i) in precos" :key="i" class="flex justify-between bg-white bg-opacity-10 p-4 rounded">
            <span>{{ p.title }}</span>
            <span class="font-semibold">{{ p.price }}</span>
          </div>
        </div>
        <p class="text-center text-gray-500 text-xs mt-6">Imagem de Freepik</p>
      </section>

      <!-- Destaque verde -->
      <section id="highlight" class="px-6 py-16 bg-[#7FAE9E] text-black">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-center">
          <div class="order-2 md:order-1">
            <h2 class="text-3xl font-bold mb-4">Melhor corte de cabelo e barba em Nova York</h2>
            <p class="text-sm leading-relaxed">
              Ipsum aenean elementum venenatis velit laoreet risus vehicula. Quis mattis vulputate enim nulla aliquet porttitor lacus luctus.
            </p>
          </div>
          <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Destaque" class="rounded-lg shadow-lg w-full h-auto object-cover order-1 md:order-2" />
        </div>
        <button class="mt-8 block mx-auto px-4 py-2 bg-black text-white uppercase text-xs rounded">Marque um horário</button>
      </section>

      <!-- Call to Action -->
      <section id="call" class="px-6 py-16 bg-black text-white text-center">
        <h3 class="text-xl font-semibold mb-4">Você está pronto para o barbear mais suave que já teve?</h3>
        <button class="px-4 py-2 bg-[#7FAE9E] text-black uppercase text-xs rounded">+1 (777) 787 87 78</button>
      </section>

      <!-- Consulta gratuita -->
      <section id="consulta" class="px-6 py-16 grid md:grid-cols-2 gap-8">
        <img src="/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg" alt="Consulta gratuita" class="rounded-lg shadow-lg w-full h-auto object-cover" />
        <div class="bg-white text-black p-6 rounded-lg shadow-lg flex flex-col justify-center">
          <h2 class="text-2xl font-bold mb-4">Consulta gratuita</h2>
          <p class="text-sm leading-relaxed mb-4">
            Entre em contato com nossos barbeiros especialistas para uma consulta individual GRATUITA.
          </p>
          <button class="px-4 py-2 bg-black text-white uppercase text-xs rounded">Agende agora</button>
          <p class="text-xs text-gray-500 mt-4">Imagem de Freepik</p>
        </div>
      </section>

      <!-- Depoimentos -->
      <section id="depoimentos" class="px-6 py-16 bg-[#7FAE9E] text-black text-center">
        <h2 class="text-3xl font-bold mb-8">Depoimentos</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8">
          <div v-for="(t,i) in testimonials" :key="i" class="space-y-4">
            <img :src="t.imagem" alt="" class="w-20 h-20 object-cover rounded-full mx-auto" />
            <h3 class="font-semibold">{{ t.author }}</h3>
            <p class="text-sm leading-relaxed italic">"{{ t.text }}"</p>
          </div>
        </div>
      </section>

      <!-- Corte destaque -->
      <section id="sobre" class="px-6 py-16 bg-black text-white grid md:grid-cols-2 gap-8 items-center">
        <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Corte destaque" class="rounded-lg shadow-lg w-full h-auto object-cover" />
        <div class="border-4 border-[#7FAE9E] p-6 max-w-md">
          <h2 class="text-2xl font-bold mb-4">Corte de cabelo masculino, corte de barba</h2>
          <p class="text-sm leading-relaxed mb-4">
            Amet luctus venenatis lectus magna fringilla urna porttitor rhoncus dolor.
          </p>
          <button class="px-4 py-2 border border-white text-white uppercase text-xs hover:bg-white hover:text-black transition">Reserve um horário</button>
          <p class="text-xs text-gray-500 mt-2">Imagem de Freepik</p>
        </div>
      </section>

      <!-- Sobre extra -->
      <section class="px-6 py-16 bg-white text-black grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h2 class="text-3xl font-bold mb-4">Barbearia com serviço completo e salão de beleza masculino</h2>
          <p class="text-sm leading-relaxed mb-4">
            Aenean a dui sit amet arcu fermentum aliquet quis non purus. Cras venenatis ut sem et volutpat.
          </p>
          <button class="px-4 py-2 bg-[#7FAE9E] text-black uppercase text-xs rounded">Reserve um horário</button>
        </div>
        <img src="/images/templates/barbershop/barber-shop-logo.jpg" alt="Salão" class="rounded-lg shadow-lg w-full h-auto object-cover" />
      </section>

      <!-- Contato -->
      <section id="contato" class="px-6 py-16 bg-black text-white text-center">
        <h2 class="text-3xl font-bold mb-6">Contate-nos</h2>
        <form class="max-w-md mx-auto grid gap-4">
          <input type="text" placeholder="Your name" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-500" />
          <input type="text" placeholder="Your phone (e.g. +1 5555555555)" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-500" />
          <input type="date" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-500" />
          <textarea rows="4" placeholder="Enter your message" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-500"></textarea>
          <button type="submit" class="px-4 py-2 bg-[#7FAE9E] text-black uppercase text-xs rounded">Enviar</button>
        </form>
        <p class="text-xs text-gray-500 mt-6">Imagem de Freepik</p>
      </section>

      <!-- Footer small -->
      <footer class="px-6 py-6 bg-black text-gray-500 text-center text-xs">
        <p>Sample text. Click to select the Frame format.</p>
      </footer>
    </main>
  </div>
</template>

<script setup>
const servicos = [
  { nome: 'Cortes de cabelo', imagem: '/images/templates/barbershop/service-haircut.png' },
  { nome: 'Barba e mais', imagem: '/images/templates/barbershop/close-up-man-getting-groomed.jpg' },
  { nome: 'Barbear', imagem: '/images/templates/barbershop/service-shave.png' },
  { nome: 'Lâmina de barbear', imagem: '/images/templates/barbershop/service-shave.webp' }
]
const precos = [
  { title: 'Corte de cabelo normal', price: '$34+' },
  { title: 'Barbear Real', price: '$35+' },
  { title: 'Corte de cabelo + barba real', price: '$60+' },
  { title: 'Corte de cabelo + barba', price: '$65+' },
  { title: 'Máquina de aparar barba', price: '$23+' },
  { title: 'Barba + Facial', price: '$55+' },
  { title: 'Corte de cabelo e rosto', price: '$50+' },
  { title: 'Facial Masculino', price: '$25+' }
]
const testimonials = [
  { author: 'Mike Larsson', text: 'Excelente serviço e ambiente acolhedor.', imagem: '/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg' },
  { author: 'Nicole Thomson', text: 'Recomendo a todos os amigos.', imagem: '/images/templates/barbershop/barber.jpg' },
  { author: 'Olga Laounda', text: 'Profissionais de primeira.', imagem: '/images/templates/barbershop/blog-8-1000x731.jpg' }
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
