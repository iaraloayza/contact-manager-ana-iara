<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 bg-pattern opacity-30"></div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-blue-200 to-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute top-40 right-20 w-32 h-32 bg-gradient-to-r from-purple-200 to-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute bottom-20 left-1/2 w-32 h-32 bg-gradient-to-r from-cyan-200 to-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    
    <!-- Header/Navigation -->
    <Header 
      :user="$page.props.auth.user" 
      :unread-count="unreadCount" 
      :is-notifications-page="true" 
    />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
      <!-- Breadcrumb -->
      <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <Link 
              href="/contacts" 
              class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-blue-600 transition-colors"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4"/>
              </svg>
              Contatos
            </Link>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
              </svg>
              <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Notificações</span>
            </div>
          </li>
        </ol>
      </nav>

      <!-- Main Content Card -->
      <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-slate-200/50">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-10">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-3xl font-bold text-white tracking-tight">Suas Notificações</h2>
              <p class="text-blue-100 mt-2 text-lg">
                Total: {{ notifications.data.length }} notificações
                <span v-if="unreadCount > 0" class="ml-2 bg-white/20 text-white text-sm px-3 py-1 rounded-full">
                  {{ unreadCount }} não lidas
                </span>
              </p>
            </div>
            <div class="flex items-center space-x-3">
              <button
                v-if="unreadCount > 0"
                @click="markAllAsRead"
                class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg border border-white/30 flex items-center space-x-2"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Marcar todas como lidas</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-slate-50 px-8 py-6 border-b border-slate-200">
          <div class="flex flex-wrap gap-3">
            <Link 
              href="/clear-notifications"
              method="delete"
              as="button"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center space-x-2 shadow-sm"
              @click="confirmClear"
            >
              <span>🗑️</span>
              <span>Limpar Todas</span>
            </Link>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="notifications.data.length === 0" class="px-8 py-20 text-center">
          <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-8 border border-slate-200">
            <!-- Ícone de Notificações para Empty State -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-16 h-16 text-slate-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-slate-800 mb-4">Nenhuma notificação encontrada</h3>
          <p class="text-slate-600 mb-8 text-lg">Você ainda não possui notificações.</p>
        </div>
        
        <!-- Notifications List -->
        <div v-else class="divide-y divide-slate-200">
          <div 
            v-for="notification in notifications.data" 
            :key="notification.id"
            class="px-8 py-6 hover:bg-slate-50 transition-colors"
            :class="notification.read_at ? 'bg-white' : 'bg-blue-50/50'"
          >
            <div class="flex items-start justify-between">
              <div class="flex items-start space-x-4 flex-1">
                <!-- Ícone Individual da Notificação -->
                <div class="flex-shrink-0 w-12 h-12">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                        </svg>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                  <div class="flex items-center space-x-2">
                    <h3 class="text-lg font-semibold text-slate-800">
                      {{ notification.data.title }}
                    </h3>
                    <span 
                      v-if="!notification.read_at"
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                    >
                      Nova
                    </span>
                  </div>
                  <p class="text-slate-600 mt-1 text-base">{{ notification.data.message }}</p>
                  <p class="text-slate-500 text-sm mt-1">
                    <span class="font-medium">Responsável:</span> {{ notification.data.action_by }}
                  </p>
                  <div class="flex items-center space-x-4 mt-3">
                    <span class="text-sm text-slate-500">{{ formatDate(notification.created_at) }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                      {{ notification.type }}
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- Actions -->
              <div class="flex items-center space-x-3">
                <button
                  v-if="!notification.read_at"
                  @click="markAsRead(notification.id)"
                  class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-all duration-200 border border-blue-200 flex items-center space-x-2 text-sm font-medium"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span>Marcar como lida</span>
                </button>
                <button
                  v-else
                  @click="markAsUnread(notification.id)"
                  class="bg-orange-50 hover:bg-orange-100 text-orange-600 px-4 py-2 rounded-lg transition-all duration-200 border border-orange-200 flex items-center space-x-2 text-sm font-medium"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                  </svg>
                  <span>Marcar como não lida</span>
                </button>
                <div class="w-3 h-3 rounded-full" :class="notification.read_at ? 'bg-slate-300' : 'bg-blue-500'"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-8">
        <p class="text-slate-500 text-sm">
          © 2025 Notification Manager. Gerencie suas notificações com estilo.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({
  notifications: Object,
  unreadCount: Number
})

const showUserMenu = ref(false)
const userMenuRef = ref(null)

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const closeUserMenu = () => {
  showUserMenu.value = false
}

const formatDate = (date) => {
  return new Date(date).toLocaleString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const markAsRead = (notificationId) => {
  router.patch(`/notifications/${notificationId}/mark-as-read`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['notifications', 'unreadCount'] })
    }
  })
}

const markAsUnread = (notificationId) => {
  router.patch(`/notifications/${notificationId}/mark-as-unread`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['notifications', 'unreadCount'] })
    }
  })
}

const markAllAsRead = () => {
  router.patch('/notifications/mark-all-as-read', {}, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['notifications', 'unreadCount'] })
    }
  })
}

const confirmClear = (e) => {
  if (!confirm('Tem certeza que deseja remover todas as notificações?')) {
    e.preventDefault()
  }
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
.bg-pattern {
  background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23000000" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
}

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