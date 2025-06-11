<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({ permissions: Object, report: Object })

const form = useForm({
  name: props.report?.name || '',
  open_mode: props.report?.open_mode || 'samePage',
  acl: props.report?.acl || []
})

function submit() {
  if (props.report) {
    form.post(route('relatorios.update', props.report.uuid), { _method: 'put' })
  } else {
    form.post(route('relatorios.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Cadastro Modelo de Relatório" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">Cadastro Modelo de Relatório</h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <InputLabel for="name" value="Nome" />
          <input id="name" v-model="form.name" type="text" class="input" />
          <InputError :message="form.errors.name" />
        </div>
        <div>
          <InputLabel for="open_mode" value="Modo de Abertura" />
          <select id="open_mode" v-model="form.open_mode" class="input">
            <option value="samePage">Na Mesma Página</option>
            <option value="newPage">Nova Página</option>
          </select>
          <InputError :message="form.errors.open_mode" />
        </div>
        <div>
          <InputLabel for="acl" value="Permissões (ACL)" />
          <select id="acl" v-model="form.acl" multiple class="input">
            <option value="0">Nenhum</option>
            <option v-for="p in permissions" :key="p.name" :value="p.name">{{ p.name }}</option>
          </select>
          <InputError :message="form.errors.acl" />
        </div>
        <div class="flex gap-2">
          <Link :href="route('relatorios.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
          <button type="submit" class="px-4 py-2 bg-brown-700 text-white rounded hover:bg-brown-600" :disabled="form.processing">
            Salvar
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
