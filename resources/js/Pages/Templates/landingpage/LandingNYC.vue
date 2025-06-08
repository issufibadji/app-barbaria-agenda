<template>
  <div class="font-sans scroll-smooth">

    <!-- Navbar -->
    <header class="bg-[#7FAE9E] px-6 py-4 flex items-center justify-between">
      <div class="text-2xl font-bold">Logo</div>
      <nav class="hidden md:flex space-x-6 text-black uppercase text-sm">
        <a href="#inicio"    class="hover:underline">Início</a>
        <a href="#sobre"     class="hover:underline">Sobre</a>
        <a href="#servicos"  class="hover:underline">Serviços</a>
        <a href="#precos"    class="hover:underline">Preços</a>
        <a href="#marcar"    class="hover:underline">Agendar</a>
        <a href="#premios"   class="hover:underline">Prêmios</a>
        <a href="#depoimento"class="hover:underline">Depoimento</a>
        <a href="#contato"   class="hover:underline">Contato</a>
      </nav>
      <button class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </header>

    <main>

      <!-- Início / Hero -->
      <section
        id="inicio"
        class="bg-[#7FAE9E] px-6 py-16"
      >
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6 items-center">
          <div class="relative">
            <div class="absolute -left-4 -top-4 bg-white p-6 rounded-lg shadow-lg max-w-xs">
              <h2 class="font-bold text-2xl mb-2">Barbearia Profissional Manhattan</h2>
              <p class="text-xs text-gray-500 mb-4">Imagem de Freepik</p>
              <button class="bg-black text-white px-4 py-2 rounded">Saiba mais</button>
            </div>
          </div>
          <img
            src="/images/templates/barbershop/barber.jpg"
            alt="Barbeiro estiloso"
            class="rounded-lg shadow-lg w-full h-auto object-cover"
          />
        </div>
      </section>

      <!-- Sobre -->
      <section
        id="sobre"
        class="bg-white px-6 py-16 text-black"
      >
        <div class="max-w-5xl mx-auto text-center">
          <h2 class="text-3xl font-bold mb-8">Sobre a Barbearia NYC</h2>
          <div class="grid md:grid-cols-2 gap-8 text-sm leading-relaxed">
            <p>
              Nossa barbearia combina tradição e inovação, oferecendo cortes
              modernos e clássicos em um ambiente acolhedor. Cada detalhe é
              pensado para garantir sua melhor experiência.
            </p>
            <p>
              Localizada no coração de Manhattan, nossa equipe de barbeiros
              especializados está pronta para transformar seu visual com
              precisão e estilo. Venha nos visitar!
            </p>
          </div>
          <button class="mt-8 bg-black text-white px-6 py-3 rounded">Saiba mais</button>
        </div>
      </section>

      <!-- Serviços e Preços -->
      <section
        id="servicos"
        class="bg-black text-white px-6 py-16"
      >
        <div class="max-w-5xl mx-auto text-center">
          <h2 class="text-3xl font-bold mb-8">Serviços e preços</h2>
          <div class="grid md:grid-cols-3 gap-6 text-sm">
            <div>
              <h3 class="font-semibold mb-2">Cortes de cabelo</h3>
              <ul class="space-y-1">
                <li class="flex justify-between"><span>Normal</span><span>$34+</span></li>
                <li class="flex justify-between"><span>Tesoura</span><span>$37+</span></li>
              </ul>
            </div>
            <div>
              <h3 class="font-semibold mb-2">Fazer a barba</h3>
              <ul class="space-y-1">
                <li class="flex justify-between"><span>Tradicional</span><span>$37+</span></li>
                <li class="flex justify-between"><span>Navalha</span><span>$49+</span></li>
              </ul>
            </div>
            <div>
              <h3 class="font-semibold mb-2">Combinação</h3>
              <ul class="space-y-1">
                <li class="flex justify-between"><span>Corte + Barba real</span><span>$50</span></li>
                <li class="flex justify-between"><span>Barba real</span><span>$60</span></li>
              </ul>
            </div>
          </div>
          <button class="mt-8 bg-white text-black font-semibold px-6 py-3 rounded">Saiba mais</button>
        </div>
      </section>

      <!-- Marcar um horário -->
      <section
        id="marcar"
        class="bg-white px-6 py-16 text-black"
      >
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 items-center">
          <img
            src="/images/templates/barbershop/portrait-male-hairdresser-with-beard-standing-barber-shop.jpg"
            alt="Agende um horário"
            class="rounded-full w-48 h-48 object-cover mx-auto md:mx-0 shadow-lg"
          />
          <div>
            <h3 class="text-2xl font-bold mb-4">Marcar um horário</h3>
            <p class="text-sm leading-relaxed mb-4">
              Escolha data e hora com antecedência e garanta seu atendimento
              com conforto e estilo na nossa barbearia em Manhattan.
            </p>
            <button class="bg-black text-white px-6 py-3 rounded">Marcar um horário</button>
          </div>
        </div>
      </section>

      <!-- Nossos Prêmios -->
      <section
        id="premios"
        class="bg-[#7FAE9E] px-6 py-16 text-center"
      >
        <div class="max-w-5xl mx-auto">
          <h2 class="text-3xl font-bold mb-8">Nossos Prêmios</h2>
          <div class="grid sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
              <img src="/images/templates/barbershop/18785178.png" alt="" class="mx-auto h-12 mb-4" />
              <p class="text-sm">Melhor Barbearia 2022</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
              <img src="/images/templates/barbershop/18927978.png" alt="" class="mx-auto h-12 mb-4" />
              <p class="text-sm">Expertise em Estilo 2021</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
              <img src="/images/templates/barbershop/18785178.png" alt="" class="mx-auto h-12 mb-4" />
              <p class="text-sm">Excelência em Atendimento 2020</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Depoimento -->
      <section
        id="depoimento"
        class="bg-white px-6 py-16 text-black"
      >
        <div class="max-w-5xl mx-auto relative">
          <span class="absolute -left-8 -top-8 w-40 h-40 bg-[#7FAE9E] rounded-full"></span>
          <span class="absolute right-0 bottom-0 w-56 h-56 bg-[#DDECE6] rounded-full"></span>

          <img
            src="/images/templates/barbershop/barber.jpg"
            alt="Depoimento"
            class="relative rounded-full w-40 h-40 object-cover mx-auto shadow-lg"
          />

          <div class="mt-8 bg-white p-6 rounded-lg shadow max-w-md mx-auto">
            <h3 class="font-semibold text-xl mb-2">Torne-se a melhor versão de si mesmo!</h3>
            <p class="text-xs text-gray-500 mb-4">Imagem de Freepik</p>
            <p class="text-sm">Mark Smith<br /><span class="text-gray-500">Barbeiro, California</span></p>
          </div>
        </div>
      </section>

      <!-- Contato -->
      <section
        id="contato"
        class="bg-gray-800 px-6 py-16 text-white"
      >
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
          <div class="space-y-4">
            <h2 class="text-3xl font-bold">Contate-nos!</h2>
            <p class="text-sm">
              Dúvidas, sugestões ou agendamentos? Preencha o formulário ao lado e
              entraremos em contato o mais breve possível.
            </p>
          </div>
          <form class="space-y-4">
            <input
              type="text"
              placeholder="Seu nome"
              class="w-full px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400"
            />
            <input
              type="email"
              placeholder="Seu e-mail"
              class="w-full px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400"
            />
            <textarea
              rows="4"
              placeholder="Sua mensagem"
              class="w-full px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400"
            ></textarea>
            <button type="submit" class="bg-yellow-400 text-black px-6 py-3 rounded">
              Enviar
            </button>
          </form>
        </div>
        <p class="mt-6 text-center text-gray-400 text-xs">Imagem de Freepik</p>
      </section>

    </main>
  </div>
</template>

<script setup>
// não há lógica por enquanto
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap');
</style>
