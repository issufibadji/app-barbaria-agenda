<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'

const props = defineProps({
  chat_link: String,
})

const form = useForm({
  manual_chat_link: props.chat_link || '',
})
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto py-10 px-4">
      <h1 class="text-2xl font-bold mb-4">⚙️ Configurar Link de Agendamento</h1>

      <div class="bg-white shadow rounded p-6 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Link personalizado (ex: chat.meusistema.com/<strong>sua-barbearia</strong>)
        </label>
        <div class="flex items-center">
        <span class="bg-gray-100 border border-r-0 border-gray-300 px-3 py-2 rounded-l text-sm text-gray-600">
            chat.seusistema.com/
        </span>
        <input
            v-model="form.manual_chat_link"
            type="text"
            placeholder="sua-barbearia"
            class="flex-1 border border-gray-300 rounded-r px-3 py-2 text-sm"
            @blur="form.manual_chat_link = form.manual_chat_link.toLowerCase().replace(/[^a-z0-9\-]/g, '')"
            />

        </div>
        <p class="text-xs text-gray-500 mt-1">Escolha um nome único e profissional. Use apenas letras, números e traços.</p>
      </div>

      <button
        @click="form.post(route('settings.chat-link.update'))"
        class="bg-brown-600 text-white px-4 py-2 rounded hover:bg-brown-700"
        :disabled="form.processing"
      >
        Salvar Link
      </button>
    </div>
  </AdminLayout>
</template>
