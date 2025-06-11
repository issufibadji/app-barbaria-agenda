<script setup>
import { ref } from 'vue'
import LoginForm from './Auth/LoginForm.vue'
import RegisterForm from './Auth/RegisterForm.vue'

const isLogin = ref(true)
</script>

<template>
  <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
      <!-- Form Panel -->
      <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
        <!-- Logo -->
        <div class="flex justify-center">
          <img
            src="/images/logo.svg" alt="Logo" class="h-24 w-auto"
          />
        </div>

        <!-- Auth Box -->
        <div class="mt-12 flex flex-col items-center">
          <h1 class="text-2xl xl:text-3xl font-extrabold">
            {{ isLogin ? 'Sign in' : 'Sign up' }}
          </h1>

          <!-- Social Buttons -->
          <div class="w-full flex-1 mt-8">
            <div class="flex flex-col items-center">
              <button
                class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-brown-100 text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out focus:outline-none hover:shadow focus:shadow-sm focus:shadow-outline"
              >
                <div class="bg-white p-2 rounded-full">
                  <svg class="w-4" viewBox="0 0 533.5 544.3">
                    <path d="M533.5 278.4c0-18.5-1.5-37.1-4.7-55.3H272.1v104.8h147c-6.1 33.8-25.7 63.7-54.4 82.7v68h87.7c51.5-47.4 81.1-117.4 81.1-200.2z" fill="#4285f4" />
                    <path d="M272.1 544.3c73.4 0 135.3-24.1 180.4-65.7l-87.7-68c-24.4 16.6-55.9 26-92.6 26-71 0-131.2-47.9-152.8-112.3H28.9v70.1c46.2 91.9 140.3 149.9 243.2 149.9z" fill="#34a853" />
                    <path d="M119.3 324.3c-11.4-33.8-11.4-70.4 0-104.2V150H28.9c-38.6 76.9-38.6 167.5 0 244.4l90.4-70.1z" fill="#fbbc04" />
                    <path d="M272.1 107.7c38.8-.6 76.3 14 104.4 40.8l77.7-77.7C405 24.6 339.7-.8 272.1 0 169.2 0 75.1 58 28.9 150l90.4 70.1c21.5-64.5 81.8-112.4 152.8-112.4z" fill="#ea4335" />
                  </svg>
                </div>
                <span class="ml-4">
                  Sign {{ isLogin ? 'In' : 'Up' }} with Google
                </span>
              </button>
            </div>

            <div class="my-12 border-b text-center">
              <div class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                Or sign {{ isLogin ? 'in' : 'up' }} with e-mail
              </div>
            </div>

            <component :is="isLogin ? LoginForm : RegisterForm" />

            <p class="mt-6 text-xs text-gray-600 text-center">
              I agree to abide by templatana's
              <a href="#" class="border-b border-gray-500 border-dotted">
                Terms of Service
              </a>
              and its
              <a href="#" class="border-b border-gray-500 border-dotted">
                Privacy Policy
              </a>
            </p>

            <p class="mt-4 text-center text-sm text-gray-600">
              {{ isLogin ? "Don't have an account?" : 'Already have an account?' }}
              <button
                @click="isLogin = !isLogin"
                class="ml-4 font-medium text-brown-800 hover:text-brown-800"
              >
                {{ isLogin ? 'Sign up' : 'Sign in' }}
              </button>
            </p>
          </div>
        </div>
      </div>

      <!-- Illustration Panel -->
      <div class="flex-1 bg-brown-100 text-center hidden lg:flex">
        <div
            class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
            style="background-image: url('/images/walcame1.svg');"
        >
        </div>
        </div>
    </div>
  </div>
</template>
