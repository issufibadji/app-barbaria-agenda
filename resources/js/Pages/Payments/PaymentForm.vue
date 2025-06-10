<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  payment: Object,
  establishments: Object,
  plans: Object,
  mode: String
})

const form = useForm({
  plan_id: props.payment?.plan_id || '',
  establishment_id: props.payment?.establishment_id || '',
  mercado_payment_id: props.payment?.mercado_payment_id || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('payments.update', props.payment.id), { _method: 'put' })
  } else {
    form.post(route('payments.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Pagamento' : 'Cadastrar Pagamento'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">{{ props.mode === 'edit' ? 'Editar Pagamento' : 'Cadastrar Pagamento' }}</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-6 gap-4">
          <div class="col-span-3">
            <InputLabel for="plan_id" value="Plano" />
            <select id="plan_id" v-model="form.plan_id" class="input">
              <option value="">Selecione</option>
              <option v-for="(name, id) in plans" :key="id" :value="id">{{ name }}</option>
            </select>
            <InputError :message="form.errors.plan_id" />
          </div>
          <div class="col-span-3">
            <InputLabel for="establishment_id" value="Estabelecimento" />
            <select id="establishment_id" v-model="form.establishment_id" class="input">
              <option value="">Selecione</option>
              <option v-for="(name, id) in establishments" :key="id" :value="id">{{ name }}</option>
            </select>
            <InputError :message="form.errors.establishment_id" />
          </div>
          <div class="col-span-3">
            <InputLabel for="mercado_payment_id" value="Pagamento (MercadoPago)" />
            <input id="mercado_payment_id" v-model="form.mercado_payment_id" type="text" class="input" />
            <InputError :message="form.errors.mercado_payment_id" />
          </div>
        </div>
        <div class="flex gap-2">
          <Link :href="route('payments.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
          <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded hover:bg-violet-600" :disabled="form.processing">
            {{ props.mode === 'edit' ? 'Atualizar' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style scoped>
.input {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500;
}
</style>
