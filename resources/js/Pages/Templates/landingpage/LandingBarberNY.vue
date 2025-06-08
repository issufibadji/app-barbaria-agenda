<template>
  <div class="font-sans scroll-smooth">
    <!-- Navbar -->
    <header class="flex items-center justify-between px-6 py-4 bg-white fixed w-full z-50 shadow">
      <div class="text-2xl font-bold">Logo</div>
      <button class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <nav class="hidden md:flex space-x-6 text-sm uppercase">
        <a href="#" class="hover:text-gray-700">Início</a>
        <a href="#sobre" class="hover:text-gray-700">Sobre nós</a>
        <a href="#servicos" class="hover:text-gray-700">Serviços</a>
        <a href="#precos" class="hover:text-gray-700">Preços</a>
        <a href="#contato" class="hover:text-gray-700">Contato</a>
      </nav>
    </header>

    <main class="pt-16">
      <!-- Hero / Bem-vindo -->
      <section class="bg-white px-6 py-16">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">
          <div class="space-y-4">
            <h1 class="text-3xl font-bold">Bem-vindo à<br />Barbearia em Manhattan<br />Nova York</h1>
            <ul class="space-y-2 text-sm text-gray-600">
              <li>📍 254 W 29th St, New York, NY 10001</li>
              <li>📞 (212) 123-4567</li>
              <li>📍 342 W 37th St, New York, NY 10018</li>
            </ul>
            <button class="mt-4 bg-black text-white px-6 py-2 rounded">Vinde Online</button>
            <p class="text-xs text-gray-400">Imagem de Freepik</p>
          </div>
          <img src="/images/templates/barbershop/barber.jpg" alt="Barbeiro" class="rounded-lg shadow-lg w-full h-auto object-cover" />
        </div>
      </section>

      <!-- Galeria de Imagens -->
      <section class="px-6 py-16 space-y-6">
        <div class="max-w-5xl mx-auto grid gap-6">
          <img src="/images/templates/barbershop/close-up-man-getting-groomed.jpg" alt="Serviço" class="rounded-lg shadow-lg" />
          <div class="grid md:grid-cols-2 gap-6">
            <img src="/images/templates/barbershop/service-haircut.png" alt="Serviço" class="rounded-lg shadow-lg" />
            <img src="/images/templates/barbershop/service-shave.png" alt="Serviço" class="rounded-lg shadow-lg" />
          </div>
        </div>
      </section>

      <!-- Sobre nós -->
      <section id="sobre" class="px-6 py-16 bg-[#B0A78B] text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">
          <img src="/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg" alt="Sobre nós" class="rounded-lg shadow-lg w-full h-auto object-cover" />
          <div class="p-6 bg-white bg-opacity-20 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Sobre nós</h2>
            <p class="text-sm leading-relaxed">Somos uma barbearia familiar com décadas de tradição em Manhattan. Nossa equipe é dedicada a oferecer serviço personalizado e qualidade excepcional.</p>
            <button class="mt-6 bg-white text-black px-6 py-2 rounded">Saiba mais</button>
            <p class="text-xs text-gray-100 mt-2">Imagem de Freepik</p>
          </div>
        </div>
      </section>

      <!-- Horário & Por que escolher -->
      <section class="px-6 py-16 bg-white text-black">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
          <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="font-semibold mb-4">Horário de trabalho</h3>
            <ul class="text-sm space-y-1">
              <li>Domingo: 10h00 às 17h00</li>
              <li>Segunda a Sexta: 09h00 às 20h00</li>
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
              <li>Ambiente confortável e acolhedor</li>
              <li>Produtos de alta qualidade</li>
              <li>Localização privilegiada em Manhattan</li>
              <li>Serviço personalizado</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Serviços de barbearia -->
      <section id="servicos" class="px-6 py-16 bg-[#0D1317] text-white">
        <div class="max-w-5xl mx-auto text-center">
          <h2 class="text-3xl font-bold mb-8">Serviços de barbearia</h2>
          <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-white text-black p-6 rounded-lg shadow hover:shadow-xl transition">
              <img src="/images/templates/barbershop/service-haircut.png" alt="Corte de cabelo" class="h-12 mx-auto mb-4" />
              <h3 class="font-semibold">Corte de cabelo normal</h3>
              <p class="text-sm mt-2">$34+</p>
            </div>
            <div class="bg-white text-black p-6 rounded-lg shadow hover:shadow-xl transition">
              <img src="/images/templates/barbershop/service-shave.png" alt="Facial Masculino" class="h-12 mx-auto mb-4" />
              <h3 class="font-semibold">Facial Masculino</h3>
              <p class="text-sm mt-2">$45+</p>
            </div>
            <div class="bg-white text-black p-6 rounded-lg shadow hover:shadow-xl transition">
              <img src="/images/templates/barbershop/service-shave.webp" alt="Barba real" class="h-12 mx-auto mb-4" />
              <h3 class="font-semibold">Barba real</h3>
              <p class="text-sm mt-2">$55+</p>
            </div>
            <div class="bg-white text-black p-6 rounded-lg shadow hover:shadow-xl transition">
              <img src="/images/templates/barbershop/service-haircut.png" alt="Corte de cabelo + barba" class="h-12 mx-auto mb-4" />
              <h3 class="font-semibold">Corte + Barba</h3>
              <p class="text-sm mt-2">$65+</p>
            </div>
          </div>
          <p class="text-xs text-gray-500 mt-4">Imagem de Freepik</p>
        </div>
      </section>

      <!-- Consulta gratuita -->
      <section id="contato" class="px-6 py-16 bg-white text-center text-black">
        <h2 class="text-3xl font-bold mb-4">Consulta gratuita</h2>
        <p class="max-w-2xl mx-auto text-sm leading-relaxed mb-6">Entre em contato com nossos barbeiros especialistas para uma consulta individual GRATUITA.</p>
        <button class="bg-black text-white px-6 py-3 rounded">Saiba mais</button>
        <p class="text-xs text-gray-400 mt-4">Imagem de Freepik</p>
      </section>

      <!-- Nossos preços tabela -->
      <section class="px-6 py-16 bg-white text-black">
        <div class="max-w-5xl mx-auto">
          <h2 class="text-3xl font-bold text-center mb-8">Nossos preços</h2>
          <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div v-for="(p, i) in prices" :key="i" class="flex justify-between">
              <span>{{ p.title }}</span>
              <span class="font-semibold">{{ p.price }}</span>
            </div>
          </div>
          <p class="text-xs text-gray-400 mt-4">Imagem de Freepik</p>
        </div>
      </section>

      <!-- Depoimentos -->
      <section class="px-6 py-16 bg-white text-black">
        <div class="max-w-5xl mx-auto text-center">
          <h2 class="text-3xl font-bold mb-8">Os clientes dizem</h2>
          <div class="grid md:grid-cols-2 gap-8 items-start">
            <div>
              <img src="/images/templates/barbershop/barber-cutting.jpg" alt="Cliente" class="rounded-lg shadow-lg w-full h-auto object-cover mb-4" />
            </div>
            <div class="space-y-6 text-left">
              <div v-for="(t, i) in testimonials" :key="i" class="border-l-4 border-gray-800 pl-4">
                <p class="italic">“{{ t.text }}”</p>
                <p class="font-semibold mt-2">{{ t.author }}</p>
              </div>
            </div>
          </div>
          <p class="text-xs text-gray-400 mt-4">Imagem de Freepik</p>
        </div>
      </section>

      <!-- Formulário Contato -->
      <section class="px-6 py-16 bg-[#0D1317] text-white">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
          <div class="space-y-4">
            <h2 class="text-3xl font-bold">Contate-nos!</h2>
            <p class="text-sm">Dúvidas, sugestões ou agendamentos? Preencha o formulário ao lado e entraremos em contato em breve.</p>
          </div>
          <form class="space-y-4">
            <input type="text" placeholder="Seu nome" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400" />
            <input type="email" placeholder="Seu e-mail" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400" />
            <textarea rows="4" placeholder="Sua mensagem" class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400"></textarea>
            <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded">Enviar</button>
          </form>
        </div>
        <p class="text-xs text-gray-500 mt-6 text-center">Imagem de Freepik</p>
      </section>
    </main>
  </div>
</template>

<script setup>
const prices = [
  { title: 'Corte de cabelo normal', price: '$34+' },
  { title: 'Barbear real', price: '$35+' },
  { title: 'Corte de cabelo masculino especial', price: '$75+' },
  { title: 'Shampoo de massagem', price: '$12+' },
  { title: 'Barbear + Facial', price: '$55+' },
  { title: 'Barba + Corte', price: '$65+' },
]

const testimonials = [
  { text: 'Excelente atendimento e qualidade!', author: 'Célia Almeida' },
  { text: 'Meu corte nunca foi tão bom.', author: 'Franke Kinney' },
  { text: 'Ótima experiência, recomendo.', author: 'Phoebe Nelson' },
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
