<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({ phone: Object, mode: String, professionals: Array, establishments: Array })

const form = useForm({
  ddi: props.phone?.ddi || '',
  ddd: props.phone?.ddd || '',
  phone: props.phone?.phone || '',
  professional_id: props.phone?.professional_id || '',
  establishment_id: props.phone?.establishment_id || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('agendaai.phones.update', props.phone.id), { _method: 'put' })
  } else {
    form.post(route('agendaai.phones.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Telefone' : 'Cadastrar Telefone'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">{{ props.mode === 'edit' ? 'Editar Telefone' : 'Cadastrar Telefone' }}</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-6 gap-4">
          <div class="col-span-1">
            <InputLabel for="ddi" value="DDI" />
            <input id="ddi" v-model="form.ddi" type="text" class="input" />
            <InputError :message="form.errors.ddi" />
          </div>
          <div class="col-span-1">
            <InputLabel for="ddd" value="DDD" />
            <input id="ddd" v-model="form.ddd" type="text" class="input" />
            <InputError :message="form.errors.ddd" />
          </div>
          <div class="col-span-2">
            <InputLabel for="phone" value="Telefone" />
            <input id="phone" v-model="form.phone" type="text" class="input" />
            <InputError :message="form.errors.phone" />
          </div>
          <div class="col-span-3">
            <InputLabel for="professional_id" value="Profissional" />
            <select id="professional_id" v-model="form.professional_id" class="input">
              <option value="">Selecione</option>
              <option v-for="pro in professionals" :key="pro.id" :value="pro.id">
                {{ pro.user.name }}
              </option>
            </select>
            <InputError :message="form.errors.professional_id" />
          </div>
          <div class="col-span-3">
            <InputLabel for="establishment_id" value="Estabelecimento" />
            <select id="establishment_id" v-model="form.establishment_id" class="input">
              <option value="">Selecione</option>
              <option v-for="est in establishments" :key="est.id" :value="est.id">
                {{ est.name }}
              </option>
            </select>
            <InputError :message="form.errors.establishment_id" />
          </div>
        </div>
        <div class="flex gap-2">
          <Link :href="route('agendaai.phones.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
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
