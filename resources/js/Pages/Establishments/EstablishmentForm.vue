<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link, Head } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  establishment: Object,
  mode: String
})

const form = useForm({
  name: props.establishment?.name || '',
  link: props.establishment?.link || '',
  image: null,
  descrition: props.establishment?.descrition || ''
})

function submit() {
  if (props.mode === 'edit') {
    form.post(route('establishments.update', props.establishment.uuid), {
      _method: 'put'
    })
  } else {
    form.post(route('establishments.store'))
  }
}
</script>

<template>
  <AdminLayout>
    <Head :title="props.mode === 'edit' ? 'Editar Estabelecimento' : 'Cadastrar Estabelecimento'" />
    <div class="max-w-3xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">
        {{ props.mode === 'edit' ? 'Editar Estabelecimento' : 'Cadastrar Estabelecimento' }}
      </h1>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <InputLabel for="name" value="Nome" />
          <input id="name" v-model="form.name" type="text" class="input" />
          <InputError :message="form.errors.name" />
        </div>
        <div>
          <InputLabel for="link" value="Link" />
          <input id="link" v-model="form.link" type="url" class="input" />
          <InputError :message="form.errors.link" />
        </div>
        <div>
          <InputLabel for="image" value="Imagem" />
          <input id="image" type="file" @change="form.image = $event.target.files[0]" class="input" />
          <InputError :message="form.errors.image" />
          <img v-if="props.mode === 'edit' && props.establishment?.image" :src="'/storage/' + props.establishment.image" class="mt-2 h-24 object-cover rounded" />
        </div>
        <div>
          <InputLabel for="descrition" value="Descrição" />
          <textarea id="descrition" v-model="form.descrition" rows="4" class="input"></textarea>
          <InputError :message="form.errors.descrition" />
        </div>
        <div class="flex gap-2">
          <Link :href="route('establishments.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</Link>
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
