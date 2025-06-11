<!-- RegisterForm.vue -->
<template>
  <form @submit.prevent="submit">
    <!-- Name -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
      <input
        type="text"
        v-model="form.name"
        required
        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-brown-400 focus:bg-white"
        placeholder="John Doe"
      />
      <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
    </div>

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
        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" @click="showPassword = !showPassword">
          <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
        </button>
      </div>
      <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
    </div>

    <!-- Confirm Password -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
      <div class="relative">
        <input
          :type="showConfirmPassword ? 'text' : 'password'"
          v-model="form.password_confirmation"
          required
          class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-brown-400 focus:bg-white"
          placeholder="••••••••"
        />
        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" @click="showConfirmPassword = !showConfirmPassword">
          <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
        </button>
      </div>
      <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
    </div>

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
      <span class="ml-3">Create Account</span>
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>
