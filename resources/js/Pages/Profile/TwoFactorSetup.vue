<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  qrCodeUrl: String,
  secretKey: String,
  user: Object,
})

const code = ref('')
const form = useForm({
  code: '',
  secret: props.secretKey, // novo campo
});

// Verifica se 2FA está ativado
const isActive2FA = computed(() => props.user?.active_2fa)

// Ativar 2FA
function enable2FA() {
  form.post(route('2fa.enable'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('2FA ativado com sucesso! 🎉')

      // reset apenas o código e reatribui o secret
      form.reset('code')
      form.secret = props.secretKey

      // Força recarregamento do componente para refletir o novo estado
      router.reload({ only: ['auth'] })
    },
    onError: () => {
      toast.error('Código inválido. Tente novamente.')
    }
  })
}


// Desativar 2FA
function disable2FA() {
  if (confirm('Deseja realmente desativar o 2FA?')) {
    router.visit(route('2fa.disable'), {
      method: 'post',
      preserveScroll: true,
      onSuccess: () => {
        toast.info('2FA desativado com sucesso.')
        router.reload({ only: ['auth'] })
      },
      onError: () => {
        toast.error('Erro ao desativar 2FA.')
      }
    })
  }
}
</script>

<template>
  <div class="mt-6 border-t pt-6">
    <h2 class="text-lg font-semibold text-violet-800 dark:text-violet-100">Autenticação em 2 Fatores (2FA)</h2>

    <!-- Status atual -->
    <p class="text-sm mt-2 mb-4">
      <span class="font-semibold">Status:</span>
      <span :class="isActive2FA ? 'text-green-600 font-bold' : 'text-red-600 font-bold'">
        {{ isActive2FA ? 'Ativado' : 'Desativado' }}
      </span>
    </p>

    <!-- Ativação -->
    <div v-if="!isActive2FA">
      <p class="text-sm mb-2 text-violet-700">Escaneie o QR Code abaixo com seu app autenticador:</p>
      <img :src="qrCodeUrl" alt="QR Code 2FA" class="mb-4" />

      <p class="text-xs text-gray-500 mb-2">Ou digite este código manualmente:</p>
      <div class="text-sm font-mono bg-gray-100 p-2 rounded mb-4">{{ secretKey }}</div>
        <input
        type="text"
        v-model="form.code"
        placeholder="Código de autenticação"
        maxlength="6"
        class="border px-3 py-2 rounded w-full"
        />

    </div>

    <!-- Botões -->
    <div class="mt-4 flex gap-4">
      <button
        v-if="!isActive2FA"
        @click="enable2FA"
        :disabled="form.processing"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50"
      >
        <span v-if="form.processing">Ativando...</span>
        <span v-else>Ativar 2FA</span>
      </button>

      <button
        v-if="isActive2FA"
        @click="disable2FA"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
      >
        Desativar 2FA
      </button>
    </div>
  </div>
</template>
