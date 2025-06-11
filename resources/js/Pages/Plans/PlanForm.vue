<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  plan: Object,
  mode: String
})

const form = useForm({
  name: props.plan?.name || '',
  days: props.plan?.days || '',
  price: props.plan?.price || '',
  descrition: props.plan?.descrition || '',
  active: props.plan?.active ? true : false
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('plans.update', props.plan.id), { _method: 'put' })
  } else {
    form.post(route('plans.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Plano' : 'Cadastrar Plano'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">{{ props.mode === 'edit' ? 'Editar Plano' : 'Cadastrar Plano' }}</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-6 gap-4">
          <div class="col-span-3">
            <InputLabel for="name" value="Nome" />
            <input id="name" v-model="form.name" type="text" class="input" />
            <InputError :message="form.errors.name" />
          </div>
          <div class="col-span-2">
            <InputLabel for="days" value="Dias" />
            <input id="days" v-model="form.days" type="number" class="input" />
            <InputError :message="form.errors.days" />
          </div>
          <div class="col-span-1 flex items-center">
            <label class="flex items-center gap-2 mt-6">
              <input type="checkbox" v-model="form.active" class="rounded" /> Ativo
            </label>
          </div>
          <div class="col-span-3">
            <InputLabel for="price" value="Valor (R$)" />
            <input id="price" v-model="form.price" type="number" step="0.01" class="input" />
            <InputError :message="form.errors.price" />
          </div>
          <div class="col-span-6">
            <InputLabel for="descrition" value="Descrição" />
            <textarea id="descrition" v-model="form.descrition" rows="3" class="input"></textarea>
            <InputError :message="form.errors.descrition" />
          </div>
        </div>
        <div class="flex gap-2">
          <Link :href="route('plans.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
          <button type="submit" class="px-4 py-2 bg-brown-700 text-white rounded hover:bg-brown-600" :disabled="form.processing">
            {{ props.mode === 'edit' ? 'Atualizar' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brown-500 focus:ring-brown-500;
}
</style>
