<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div class="bg-white shadow-xl rounded-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-6">
          <img
            src="https://storage.googleapis.com/devitary-image-host.appspot.com/15846435184459982716-LogoMakr_7POjrN.png"
            alt="Logo"
            class="w-20 mx-auto mb-4"
          />
          <h2 class="text-2xl font-bold text-gray-800">Forgot your password?</h2>
          <p class="mt-2 text-gray-600 text-sm">
            No problem. Enter your email below and we'll send you a reset link.
          </p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-4 text-sm text-green-600 font-medium">
          {{ status }}
        </div>

        <!-- Form -->
        <form @submit.prevent="submit">
          <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <div class="relative">
              <input
                id="email"
                type="email"
                v-model="form.email"
                required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-violet-500 focus:border-transparent"
                placeholder="you@example.com"
              />
              <i class="fas fa-envelope absolute right-3 top-4 text-gray-400"></i>
            </div>
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            class="w-full bg-violet-500 text-white py-3 rounded-lg font-semibold hover:bg-violet-600 transition focus:ring-4 focus:ring-violet-400 focus:ring-opacity-50"
            :disabled="form.processing"
          >
            Send Password Reset Link
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3'

defineProps({
  status: String,
})

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>
