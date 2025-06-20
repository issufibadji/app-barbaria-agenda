<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const user = usePage().props.auth.user
const sidebarOpen = ref(false)
const darkMode = ref(false)
const dropdownOpen = ref(false)
const sideMenus = usePage().props.sideMenus ?? []
const roles = usePage().props.auth.roles ?? []

const filteredMenus = computed(() =>
  sideMenus.filter(m => {
    if (m.route?.startsWith('establishments')) {
      return roles.includes('super-master') || roles.includes('master')
    }
    return true
  })
)

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

// ✅ Agrupando por level (grupos visuais)
const groupedMenus = computed(() => {
  const groups = {}
  const parents = filteredMenus.value.filter(m => m.parent_id === null)

  parents.forEach(item => {
    const group =
      item.level === 1 ? 'Área Operacional'
    //   : item.level === 2 ? 'Gestão da Site'
      : item.level === 2 ? 'Gestão da Loja'
      : item.level === 3 ? 'Administração do Sistema'
      : 'Outros'

    if (!groups[group]) groups[group] = []

    groups[group].push({
      ...item,
      children: filteredMenus.value
        .filter(child => child.parent_id === item.id)
        .map(child => ({
          ...child,
          style: item.style // Herdando estilo do pai
        }))
    })
  })

  return groups
})


function defaultTextClass(groupName) {
  if (groupName === 'Área Operacional') return 'text-camel-300'
//   if (groupName === 'Gestão da Site') return 'text-vanilla-300'
  if (groupName === 'Gestão da Loja') return 'text-vanilla-300'
  if (groupName === 'Administração do Sistema') return 'text-mint-300'
  return 'text-gray-400'
}
</script>

<template>
  <div class="flex min-h-screen bg-brown-100 dark:bg-brown-950">
    <!-- Sidebar -->
    <aside :class="[
      'fixed z-40 lg:static transform transition-transform duration-300 ease-in-out w-64 bg-brown-deep text-white flex flex-col',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]">
      <div class="p-4 border-b border-brown-800 flex items-center justify-between">
        <img src="/images/logotipo.svg" alt="Logo" class="h-24 w-auto">
        <span class="text-xl font-bold">Barbershop</span>
      </div>
      <div class="p-4">
        <div class="relative">
          <input type="text" class="w-full bg-brown-800 text-white rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search...">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-brown-500"></i>
          </div>
        </div>
      </div>
        <nav class="flex-1 px-2 space-y-2">
        <Link href="/dashboard" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-brown-800 text-white hover:bg-brown-700">
            <i class="fas fa-home mr-3 w-4"></i> Dashboard
        </Link>

        <template v-for="(items, groupName) in groupedMenus" :key="groupName">
            <div class="mt-4 border-t border-brown-800 pt-2">
            <p :class="'text-xs px-4 uppercase tracking-widest mb-1 ' + defaultTextClass(groupName)">
                {{ groupName }}
            </p>

            <template v-for="item in items" :key="item.id">
                <!-- Menu sem filhos -->
                <Link
                v-if="!item.children.length"
                :href="`/${item.route}`"
                :class="[
                    'flex items-center px-4 py-2 text-sm hover:text-white hover:bg-brown-700 rounded-lg',
                    item?.style || defaultTextClass(groupName)
                ]"
                >
                <i :class="`fas ${item.icon} mr-3 w-4`"></i> {{ item.description }}
                </Link>

                <!-- Menu com filhos (dropdown) -->
                <div v-else class="pl-2">
                <p
                    class="flex items-center px-4 py-2 text-sm font-semibold text-white"
                    :class="item?.style || defaultTextClass(groupName)"
                >
                    <i :class="`fas ${item.icon} mr-3 w-4`"></i> {{ item.description }}
                </p>
                <div class="ml-4">
                    <Link
                    v-for="child in item.children"
                    :key="child.id"
                    :href="`/${child.route}`"
                    :class="[
                        'flex items-center px-4 py-2 text-sm hover:text-white hover:bg-brown-700 rounded-lg',
                        child?.style || item?.style || defaultTextClass(groupName)
                    ]"
                    >
                    <i :class="`fas ${child.icon} mr-3 w-4`"></i> {{ child.description }}
                    </Link>
                </div>
                </div>
            </template>
            </div>
        </template>
        </nav>

      <div class="p-4 border-t border-brown-800 flex items-center">
        <img class="h-8 w-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${user.name}`" alt="Avatar">
        <div class="ml-3">
          <p class="text-sm font-medium text-white">{{ user.name }}</p>
          <p class="text-xs text-brown-400">View profile</p>
        </div>
      </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="flex items-center justify-between bg-white dark:bg-brown-800 px-4 h-16 border-b dark:border-brown-700 shadow-sm">
        <button class="lg:hidden text-brown-600 dark:text-brown-300" @click="toggleSidebar">
          <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="flex items-center space-x-6 ml-auto relative">
          <button class="relative text-brown-600 dark:text-brown-300 hover:text-red-500">
            <i class="fas fa-bell text-lg"></i>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
          </button>
          <button @click="toggleDarkMode" class="text-brown-600 dark:text-brown-300 hover:text-yellow-400">
            <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'" class="text-lg"></i>
          </button>
          <div class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
              <img class="h-8 w-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${user.name}`" alt="">
              <span class="hidden md:inline-block text-sm font-medium text-brown-600 dark:text-brown-200">{{ user.name }}</span>
              <i class="fas fa-chevron-down text-xs text-brown-500"></i>
            </button>
            <div v-if="dropdownOpen" class="fixed inset-0 z-40" @click="dropdownOpen = false"></div>
            <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-brown-800 border border-brown-200 dark:border-brown-700 rounded-md shadow-lg z-50">
              <Link href="/profile" class="block px-4 py-2 text-sm text-brown-700 dark:text-brown-200 hover:bg-brown-100 dark:hover:bg-brown-700">
                <i class="fas fa-user mr-2"></i> Meu Perfil
              </Link>
              <button @click="logout" class="w-full text-left px-4 py-2 text-sm text-brown-700 dark:text-brown-200 hover:bg-brown-100 dark:hover:bg-brown-700">
                <i class="fas fa-sign-out-alt mr-2"></i> Sair
              </button>
            </div>
          </div>
        </div>
      </header>
      <!-- SLOT PARA PÁGINAS -->
      <main class="flex-1 p-6 bg-white dark:bg-brown-900 bg-gradient-to-r from-white to-brown-100 dark:from-brown-900 dark:to-brown-800">
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
