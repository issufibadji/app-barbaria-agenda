<template>
    <Toast ref="toast" />
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="bg-white rounded-xl shadow-md p-8 w-full max-w-md text-center">
      <div class="flex justify-center mb-6">
        <div class="bg-brown-100 p-3 rounded-full">
          <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2c0 1.105.895 2 2 2s2-.895 2-2zm0 0v3m0 4h.01M21 12c0-4.97-4.03-9-9-9S3 7.03 3 12s4.03 9 9 9 9-4.03 9-9z" />
          </svg>
        </div>
      </div>
      <h2 class="text-2xl font-semibold text-gray-800 mb-2">Easy peasy</h2>
      <p class="text-gray-500 mb-6">Enter 6-digit code from your two factor authenticator APP.</p>

      <div class="flex justify-center gap-2 mb-4">
        <input
          v-for="(digit, index) in 6"
          :key="index"
          v-model="code[index]"
          maxlength="1"
          @input="focusNext(index, $event)"
          type="text"
          class="w-10 h-12 text-xl text-center border-2 border-gray-300 rounded-md focus:outline-none focus:border-brown-500"
        />
      </div>

      <p class="text-gray-400 mb-4">{{ 6 - code.join('').length }} digits left</p>

      <button
        class="w-full bg-brown-500 hover:bg-brown-600 text-white py-2 rounded-md transition"
        @click="submitCode"
      >
        Verify
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Toast from '@/Components/Toast.vue'
import axios from 'axios'

const toast = ref()
const code = ref(['', '', '', '', '', ''])

function focusNext(index, event) {
  if (event.inputType === 'deleteContentBackward') return
  if (event.target.value && index < 5) {
    event.target.nextElementSibling?.focus()
  }
}

async function submitCode() {
  const finalCode = code.value.join('')

  if (finalCode.length !== 6) {
    toast.value.showToast('Digite os 6 dígitos.', 'error')
    return
  }

  try {
    const response = await axios.post('/two-factor/verify', { code: finalCode })

    if (response.data.redirect) {
      toast.value.showToast('Código verificado com sucesso!', 'success')
      setTimeout(() => router.visit(response.data.redirect), 1000)
    }
  } catch (error) {
    toast.value.showToast('Código inválido. Tente novamente.', 'error')
  }
}
</script>
