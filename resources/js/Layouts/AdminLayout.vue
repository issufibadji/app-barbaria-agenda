<script setup>
import { ref, onMounted, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const user = usePage().props.auth.user
const sidebarOpen = ref(false)
const darkMode = ref(false)
const dropdownOpen = ref(false)
const sideMenus = usePage().props.sideMenus ?? []

onMounted(() => {
  darkMode.value = localStorage.getItem('theme') === 'dark'
  updateHtmlClass()
})

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value
}

function toggleDarkMode() {
  darkMode.value = !darkMode.value
  localStorage.setItem('theme', darkMode.value ? 'dark' : 'light')
  updateHtmlClass()
}

function updateHtmlClass() {
  const html = document.documentElement
  darkMode.value ? html.classList.add('dark') : html.classList.remove('dark')
}

function logout() {
  router.post(route('logout'))
}

const groupedMenus = computed(() => {
  return sideMenus.reduce((acc, item) => {
    const group =
      item.level === 1 ? 'Área Operacional'
      : item.level === 2 ? 'Gestão da Blog'
      : item.level === 3 ? 'Gestão da Loja'
      : item.level === 4 ? 'Administração do Sistema'
      : 'Outros'

    if (!acc[group]) acc[group] = []
    acc[group].push(item)
    return acc
  }, {})
})

function defaultTextClass(groupName) {
  if (groupName === 'Área Operacional') return 'text-cyan-200'
  if (groupName === 'Gestão da Blog') return 'text-emerald-400'
  if (groupName === 'Gestão da Loja') return 'text-sky-400'
  if (groupName === 'Administração do Sistema') return 'text-yellow-400'
  return 'text-gray-400'
}
</script>

<template>
  <div class="flex min-h-screen bg-violet-100 dark:bg-violet-950">
    <!-- Sidebar -->
    <aside :class="[
      'fixed z-40 lg:static transform transition-transform duration-300 ease-in-out w-64 bg-violet-900 text-white flex flex-col',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]">
      <div class="p-4 border-b border-violet-800 flex items-center justify-between">
        <img src="https://tailwindflex.com/images/logo.svg" alt="Logo" class="h-8 w-auto">
        <span class="text-xl font-bold">Empresa A</span>
      </div>
      <div class="p-4">
        <div class="relative">
          <input type="text" class="w-full bg-violet-800 text-white rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search...">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-violet-500"></i>
          </div>
        </div>
      </div>
    <nav class="flex-1 px-2 space-y-2">
        <Link href="/dashboard" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-violet-800 text-white hover:bg-violet-700">
        <i class="fas fa-home mr-3 w-4"></i> Dashboard
        </Link>

        <template v-for="(items, groupName) in groupedMenus" :key="groupName">
        <div class="mt-4 border-t border-violet-800 pt-2">
            <p :class="'text-xs px-4 uppercase tracking-widest mb-1 ' + defaultTextClass(groupName)">
            {{ groupName }}
            </p>
            <Link
            v-for="item in items"
            :key="item.id"
            :href="`/${item.route}`"
            class="flex items-center px-4 py-2 text-sm hover:text-white hover:bg-violet-700 rounded-lg"
            :class="item.style ?? defaultTextClass(groupName).replace('text-', 'text-')"
            >
            <i :class="`fas ${item.icon} mr-3 w-4`"></i> {{ item.description }}
            </Link>
        </div>
        </template>
    </nav>

      <div class="p-4 border-t border-violet-800 flex items-center">
        <img class="h-8 w-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${user.name}`" alt="Avatar">
        <div class="ml-3">
          <p class="text-sm font-medium text-white">{{ user.name }}</p>
          <p class="text-xs text-violet-400">View profile</p>
        </div>
      </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="flex items-center justify-between bg-white dark:bg-violet-800 px-4 h-16 border-b dark:border-violet-700 shadow-sm">
        <button class="lg:hidden text-violet-600 dark:text-violet-300" @click="toggleSidebar">
          <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="flex items-center space-x-6 ml-auto relative">
          <button class="relative text-violet-600 dark:text-violet-300 hover:text-red-500">
            <i class="fas fa-bell text-lg"></i>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
          </button>
          <button @click="toggleDarkMode" class="text-violet-600 dark:text-violet-300 hover:text-yellow-400">
            <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'" class="text-lg"></i>
          </button>
          <div class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
              <img class="h-8 w-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${user.name}`" alt="">
              <span class="hidden md:inline-block text-sm font-medium text-violet-600 dark:text-violet-200">{{ user.name }}</span>
              <i class="fas fa-chevron-down text-xs text-violet-500"></i>
            </button>
            <div v-if="dropdownOpen" class="fixed inset-0 z-40" @click="dropdownOpen = false"></div>
            <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-violet-800 border border-violet-200 dark:border-violet-700 rounded-md shadow-lg z-50">
              <Link href="/profile" class="block px-4 py-2 text-sm text-violet-700 dark:text-violet-200 hover:bg-violet-100 dark:hover:bg-violet-700">
                <i class="fas fa-user mr-2"></i> Meu Perfil
              </Link>
              <button @click="logout" class="w-full text-left px-4 py-2 text-sm text-violet-700 dark:text-violet-200 hover:bg-violet-100 dark:hover:bg-violet-700">
                <i class="fas fa-sign-out-alt mr-2"></i> Sair
              </button>
            </div>
          </div>
        </div>
      </header>
      <!-- SLOT PARA PÁGINAS -->
      <main class="flex-1 p-6 bg-white dark:bg-violet-900 bg-gradient-to-r from-white to-violet-100 dark:from-violet-900 dark:to-violet-800">
        <slot />
      </main>
    </div>
  </div>
</template>

<style>
html.dark {
  background-color: #1f2937;
}
</style>
