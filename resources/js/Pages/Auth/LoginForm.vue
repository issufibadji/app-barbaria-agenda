<!-- LoginForm.vue -->
<template>
  <form @submit.prevent="submit">
    <!-- Email -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
      <div class="relative">
        <input
          type="email"
          v-model="form.email"
          required
          class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-brown-400 focus:bg-white"
          placeholder="you@example.com"
        />
        <i class="fas fa-envelope absolute right-3 top-4 text-gray-400"></i>
      </div>
      <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
    </div>

    <!-- Password -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
      <div class="relative">
        <input
          :type="showPassword ? 'text' : 'password'"
          v-model="form.password"
          required
          class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-brown-400 focus:bg-white"
          placeholder="••••••••"
        />
        <button
          type="button"
          class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
          @click="showPassword = !showPassword"
        >
          <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
        </button>
      </div>
      <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
    </div>

    <!-- Remember Me -->
    <div class="mb-6 flex items-center justify-between">
      <label class="flex items-center space-x-2 text-sm text-gray-700">
        <input type="checkbox" v-model="form.remember" class="rounded border-gray-300 text-brown-500 shadow-sm focus:ring-brown-400" />
        <span>Remember me</span>
      </label>
      <Link :href="route('password.request')" class="text-sm text-red-600 hover:text-red-700 font-medium">
        Forgot password?
      </Link>
    </div>

    <!-- Submit -->
    <button
      type="submit"
      class="w-full bg-brown-500 text-white py-3 rounded-lg font-semibold hover:bg-brown-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:outline-none focus:shadow-outline"
      :disabled="form.processing"
    >
      <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
        <circle cx="8.5" cy="7" r="4" />
        <path d="M20 8v6M23 11h-6" />
      </svg>
      <span class="ml-3">Sign In</span>
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const showPassword = ref(false)

const form = useForm({
//   email: '',
//   password: '',
  email: 'admin@agender.com',
  password: 'password',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>
