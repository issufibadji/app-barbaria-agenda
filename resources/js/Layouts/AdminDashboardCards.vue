<script setup>
defineProps({
  establishment: Object,
})
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card: Estabelecimento -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-4 flex items-start gap-4">
      <i class="fas fa-store text-2xl text-brown-500 mt-1"></i>
      <div>
        <h2 class="text-lg font-semibold text-brown-800 dark:text-white">Estabelecimento</h2>
        <p :class="establishment?.name ? 'text-brown-600' : 'text-red-500 dark:text-red-400'">
          {{ establishment?.name || 'Nome não cadastrado' }}
        </p>
        <p class="text-sm text-brown-500">CNPJ: {{ establishment?.cnpj || '---' }}</p>
      </div>
    </div>

    <!-- Card: Contato -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-4 flex items-start gap-4">
      <i class="fas fa-phone text-2xl text-brown-500 mt-1"></i>
      <div>
        <h2 class="text-lg font-semibold text-brown-800 dark:text-white">Contato</h2>
        <p :class="establishment?.address ? 'text-brown-600' : 'text-red-500 dark:text-red-400'">
          Endereço: {{ establishment?.address || 'Não informado' }}
        </p>
        <p :class="establishment?.phone ? 'text-brown-600' : 'text-red-500 dark:text-red-400'">
          Telefone: {{ establishment?.phone || 'Não informado' }}
        </p>
      </div>
    </div>

    <!-- Card: Resumo -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-4 flex items-start gap-4">
      <i class="fas fa-chart-pie text-2xl text-brown-500 mt-1"></i>
      <div>
        <h2 class="text-lg font-semibold text-brown-800 dark:text-white">Resumo</h2>
        <p class="text-brown-600 dark:text-brown-200">Agendamentos: {{ establishment?.appointments_count }}</p>
        <p class="text-brown-600 dark:text-brown-200">Profissionais: {{ establishment?.professionals_count }}</p>
        <p class="text-brown-600 dark:text-brown-200">Clientes: {{ establishment?.clients_count }}</p>
      </div>
    </div>

    <!-- Card: Faturamento -->
    <div class="bg-white dark:bg-brown-800 rounded-lg shadow p-4 col-span-1 md:col-span-2 flex items-start gap-4">
      <i class="fas fa-dollar-sign text-3xl text-green-600 mt-1"></i>
      <div>
        <h2 class="text-lg font-semibold text-brown-800 dark:text-white">Faturamento</h2>
        <p
          :class="{
            'text-green-600 dark:text-green-400': establishment?.revenue >= 1000,
            'text-yellow-500 dark:text-yellow-400': establishment?.revenue > 0 && establishment?.revenue < 1000,
            'text-red-500 dark:text-red-400': establishment?.revenue <= 0
          }"
          class="text-2xl font-bold"
        >
          R$ {{ establishment?.revenue?.toFixed(2) || '0.00' }}
        </p>
      </div>
    </div>
  </div>
</template>
