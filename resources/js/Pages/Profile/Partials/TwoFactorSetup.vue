<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  qrCodeUrl: String,
  secretKey: String,
})

const page = usePage()
const user = computed(() => page.props.user)

const code = ref('')
const form = useForm({ code })

function enable2FA() {
  form.post(route('2fa.enable'))
}

function disable2FA() {
  router.post(route('2fa.disable'))
}
</script>

<template>
  <div class="mt-6 border-t pt-6">
    <h2 class="text-lg font-semibold text-violet-800 dark:text-violet-100">Autenticação em 2 Fatores (2FA)</h2>

    <div v-if="!user.value?.active_2fa">
      <p class="text-sm mb-2 text-violet-700">Escaneie o QR Code abaixo com seu app autenticador:</p>
      <img :src="qrCodeUrl" alt="QR Code 2FA" class="mb-4" />

      <p class="text-xs text-gray-500 mb-2">Ou digite este código manualmente:</p>
      <div class="text-sm font-mono bg-gray-100 p-2 rounded mb-4">{{ secretKey }}</div>

      <input
        v-model="form.code"
        placeholder="Código de autenticação"
        class="border px-3 py-2 rounded w-full mb-2"
      />
      <button @click="enable2FA" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Ativar 2FA
      </button>
    </div>

    <div v-else>
      <p class="text-sm text-green-700 mb-4">2FA está ativado para esta conta.</p>
      <button @click="disable2FA" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Desativar 2FA
      </button>
    </div>
  </div>
</template>
