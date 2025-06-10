<script setup>
import { onMounted } from 'vue'

const props = defineProps({ dados: Object })

onMounted(() => {
  const mp = new window.MercadoPago(import.meta.env.VITE_PUBLIC_KEY_MP, { locale: 'pt-BR' })
  const bricksBuilder = mp.bricks()
  const settings = {
    initialization: {
      amount: props.dados.valor,
      preferenceId: '0001',
      payer: {}
    },
    callbacks: {
      onSubmit: ({ formData }) => {
        return new Promise((resolve, reject) => {
          fetch('/mercadopago/process_payment', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ formData, dados: props.dados })
          })
            .then(r => r.json())
            .then(res => {
              document.getElementById('paymentBrick_container').style.display = 'none'
              document.querySelector('.qrcode').style.display = 'block'
              document.getElementById('pixImgQrCode').src = 'data:image/png;base64,' + res.qr_code_base64
              document.getElementById('codigo-pix').value = res.qr_code
              resolve()
            })
            .catch(() => {
              alert('Erro ao criar o pagamento!')
              reject()
            })
        })
      }
    }
  }
  bricksBuilder.create('payment', 'paymentBrick_container', settings)
})
</script>

<template>
  <div>
    <div id="paymentBrick_container"></div>
    <div class="container mt-5 qrcode" style="display:none;">
      <div class="flex justify-center">
        <div class="text-center">
          <h3 class="mb-4">QRCode do Pix:</h3>
          <img id="pixImgQrCode" class="mx-auto mb-4" style="max-height:285px" />
          <p class="mb-4">Se já efetuou o pagamento, já pode sair dessa página!</p>
          <h3 class="mb-4">Linha do Pix (Copia e Cola):</h3>
          <input id="codigo-pix" type="text" class="input mb-3" />
          <button id="copy-button" class="px-4 py-2 bg-blue-500 text-white rounded">Copiar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.input {
  @apply border rounded px-2 py-1 w-full;
}
</style>
