<template>
  <nav class="relative z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200/50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center space-x-4">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Contact Manager</h1>
            <p class="text-sm text-slate-600">Gerencie seus contatos com estilo</p>
          </div>
        </div>
        
        <div class="flex items-center space-x-4">
          <!-- Notifications Button (mostrado apenas se não estiver na página de notificações) -->
          <Link
            v-if="!isNotificationsPage"
            href="/notifications"
            class="relative flex items-center space-x-2 text-slate-700 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-xl p-3 bg-white/60 backdrop-blur-sm border border-slate-200/50 transition-all duration-200 cursor-pointer hover:bg-white/80"
          >
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
              </svg>
              <span v-if="unreadCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                {{ unreadCount > 9 ? '9+' : unreadCount }}
              </span>
            </div>
            <span class="font-medium hidden sm:inline">Notificações</span>
          </Link>

          <!-- Back to Contacts Button (mostrado apenas na página de notificações) -->
          <Link
            v-if="isNotificationsPage"
            href="/contacts"
            class="relative flex items-center space-x-2 text-slate-700 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-xl p-3 bg-white/60 backdrop-blur-sm border border-slate-200/50 transition-all duration-200 cursor-pointer hover:bg-white/80"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <span class="font-medium hidden sm:inline">Contatos</span>
          </Link>

          <!-- User Menu -->
          <div class="relative z-50" ref="userMenuRef">
            <button
              @click="toggleUserMenu"
              class="flex items-center space-x-3 text-slate-700 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-xl p-3 bg-white/60 backdrop-blur-sm border border-slate-200/50 transition-all duration-200 cursor-pointer"
            >
              <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <div class="text-left hidden sm:block">
                <div class="text-sm font-medium text-slate-800">{{ user.name }}</div>
                <div class="text-xs text-slate-500">{{ user.email }}</div>
              </div>
              <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': showUserMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div 
              v-if="showUserMenu" 
              class="absolute right-0 mt-2 w-48 bg-white/95 backdrop-blur-xl rounded-xl shadow-2xl py-2 z-[9999] border border-slate-200/50 animate-fadeIn"
            >
              <Link
                href="/profile"
                class="flex items-center w-full px-4 py-3 text-sm text-slate-700 hover:bg-slate-100/80 transition-colors rounded-lg mx-1 cursor-pointer font-medium"
                @click="closeUserMenu"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Perfil
              </Link>
              
              <button
                @click="logout"
                class="flex items-center w-full px-4 py-3 text-sm text-slate-700 hover:bg-slate-100/80 transition-colors rounded-lg mx-1 cursor-pointer font-medium"
              >
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sair
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  user: Object,
  unreadCount: {
    type: Number,
    default: 0
  },
  isNotificationsPage: {
    type: Boolean,
    default: false
  }
})

const showUserMenu = ref(false)
const userMenuRef = ref(null)

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const closeUserMenu = () => {
  showUserMenu.value = false
}

const logout = () => {
  router.post('/logout', {}, {
    onSuccess: () => {
      // Redirect será tratado pelo backend
    },
    onError: (errors) => {
      console.error('Erro ao fazer logout:', errors)
    }
  })
}

// Close user menu when clicking outside
const handleClickOutside = (event) => {
  if (showUserMenu.value && userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    closeUserMenu()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.2s ease-out;
}
</style>