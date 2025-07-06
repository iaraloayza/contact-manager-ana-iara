<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 bg-pattern opacity-30"></div>

    <!-- Floating Elements - Mais sutis -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-blue-200 to-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute top-40 right-20 w-32 h-32 bg-gradient-to-r from-purple-200 to-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute bottom-20 left-1/2 w-32 h-32 bg-gradient-to-r from-cyan-200 to-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    
    <!-- Header/Navigation -->
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
            <div class="relative z-50" ref="userMenuRef">
              <button
                @click="toggleUserMenu"
                class="flex items-center space-x-2 text-slate-700 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-xl p-3 bg-white/60 backdrop-blur-sm border border-slate-200/50 transition-all duration-200 cursor-pointer"
              >
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
      <!-- Success Message -->
      <div v-if="success" class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ success }}</p>
          </div>
        </div>
      </div>

      <!-- Main Content Card -->
      <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-slate-200/50">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-10">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-3xl font-bold text-white tracking-tight">Seus Contatos</h2>
              <p class="text-blue-100 mt-2 text-lg">Organize e gerencie sua lista de contatos</p>
            </div>
            <button
              @click="openCreateModal"
              class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg border border-white/30 flex items-center space-x-3"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              <span>Novo Contato</span>
            </button>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="contacts.data.length === 0" class="px-8 py-20 text-center">
          <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-8 border border-slate-200">
            <svg class="w-16 h-16 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
              <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-slate-800 mb-4">Nenhum contato encontrado</h3>
          <p class="text-slate-600 mb-8 text-lg">Comece adicionando seu primeiro contato à lista.</p>
          <button
            @click="openCreateModal"
            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            Criar Primeiro Contato
          </button>
        </div>
        
        <!-- Contacts Table -->
        <div v-else class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
              <tr>
                <th class="px-8 py-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                  Nome
                </th>
                <th class="px-8 py-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                  Email
                </th>
                <th class="px-8 py-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                  Telefone
                </th>
                <th class="px-8 py-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                  Ações
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
              <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-slate-50 transition-colors">
                <td class="px-8 py-6 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12">
                      <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-lg">{{ contact.name.charAt(0).toUpperCase() }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-semibold text-slate-800">{{ contact.name }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                  <div class="text-sm text-slate-600">{{ contact.email }}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                  <div class="text-sm text-slate-600">{{ formatPhone(contact.phone) }}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-3">
                    <button
                      @click="editContact(contact)"
                      class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-all duration-200 border border-blue-200 flex items-center space-x-2"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      <span>Editar</span>
                    </button>
                    <button
                      @click="deleteContact(contact)"
                      class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg transition-all duration-200 border border-red-200 flex items-center space-x-2"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      <span>Excluir</span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="bg-slate-50 px-8 py-6 border-t border-slate-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 flex justify-between sm:hidden">
                <Link
                  v-if="contacts.prev_page_url"
                  :href="contacts.prev_page_url"
                  class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors"
                >
                  Anterior
                </Link>
                <Link
                  v-if="contacts.next_page_url"
                  :href="contacts.next_page_url"
                  class="ml-3 relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors"
                >
                  Próximo
                </Link>
              </div>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm text-slate-600">
                    Mostrando <span class="font-medium text-slate-800">{{ contacts.from }}</span> a <span class="font-medium text-slate-800">{{ contacts.to }}</span> de <span class="font-medium text-slate-800">{{ contacts.total }}</span> resultados
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px">
                    <Link
                      v-if="contacts.prev_page_url"
                      :href="contacts.prev_page_url"
                      class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-slate-300 bg-white text-sm font-medium text-slate-500 hover:bg-slate-50 transition-colors"
                    >
                      <span class="sr-only">Anterior</span>
                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                      </svg>
                    </Link>
                    
                    <template v-for="page in paginationRange" :key="page">
                      <Link
                        v-if="page !== '...'"
                        :href="contacts.path + '?page=' + page"
                        :class="[
                          page === contacts.current_page
                            ? 'bg-blue-500 border-blue-500 text-white'
                            : 'bg-white border-slate-300 text-slate-500 hover:bg-slate-50',
                          'relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors'
                        ]"
                      >
                        {{ page }}
                      </Link>
                      <span v-else class="relative inline-flex items-center px-4 py-2 border border-slate-300 bg-white text-sm font-medium text-slate-500">
                        ...
                      </span>
                    </template>
                    
                    <Link
                      v-if="contacts.next_page_url"
                      :href="contacts.next_page_url"
                      class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-slate-300 bg-white text-sm font-medium text-slate-500 hover:bg-slate-50 transition-colors"
                    >
                      <span class="sr-only">Próximo</span>
                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                      </svg>
                    </Link>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-8">
        <p class="text-slate-500 text-sm">
          © 2024 Contact Manager. Gerencie seus contatos com estilo.
        </p>
      </div>
    </div>

    <!-- Contact Modal -->
    <ContactModal
      v-if="showModal"
      :contact="selectedContact"
      :is-edit="isEdit"
      @close="closeModal"
      @submit="handleSubmit"
    />

    <!-- Delete Confirmation Modal -->
    <ConfirmModal
      v-if="showDeleteModal"
      title="Excluir Contato"
      :message="`Tem certeza que deseja excluir o contato '${contactToDelete?.name}'?`"
      @confirm="confirmDelete"
      @cancel="closeDeleteModal"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ContactModal from './ContactModal.vue'
import ConfirmModal from './ConfirmModal.vue'

const props = defineProps({
  contacts: Object,
  success: String
})

const showModal = ref(false)
const showDeleteModal = ref(false)
const showUserMenu = ref(false)
const selectedContact = ref(null)
const contactToDelete = ref(null)
const isEdit = ref(false)
const userMenuRef = ref(null)

const paginationRange = computed(() => {
  const range = []
  const total = props.contacts.last_page
  const current = props.contacts.current_page
  
  if (total <= 7) {
    for (let i = 1; i <= total; i++) {
      range.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) {
        range.push(i)
      }
      range.push('...')
      range.push(total)
    } else if (current >= total - 3) {
      range.push(1)
      range.push('...')
      for (let i = total - 4; i <= total; i++) {
        range.push(i)
      }
    } else {
      range.push(1)
      range.push('...')
      for (let i = current - 1; i <= current + 1; i++) {
        range.push(i)
      }
      range.push('...')
      range.push(total)
    }
  }
  
  return range
})

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

const openCreateModal = () => {
  selectedContact.value = null
  isEdit.value = false
  showModal.value = true
}

const editContact = (contact) => {
  selectedContact.value = { ...contact }
  isEdit.value = true
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedContact.value = null
  isEdit.value = false
}

const deleteContact = (contact) => {
  contactToDelete.value = contact
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  contactToDelete.value = null
}

const confirmDelete = () => {
  if (contactToDelete.value?.id) {
    router.delete(`/contacts/${contactToDelete.value.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        closeDeleteModal()
      },
      onError: (errors) => {
        console.error('Erro ao excluir contato:', errors)
      }
    })
  }
}

const handleSubmit = (formData) => {
  if (isEdit.value && selectedContact.value?.id) {
    router.put(`/contacts/${selectedContact.value.id}`, formData, {
      preserveScroll: true,
      onSuccess: () => {
        closeModal()
      },
      onError: (errors) => {
        console.error('Erro ao atualizar contato:', errors)
      }
    })
  } else {
    router.post('/contacts', formData, {
      preserveScroll: true,
      onSuccess: () => {
        closeModal()
      },
      onError: (errors) => {
        console.error('Erro ao criar contato:', errors)
      }
    })
  }
}

const formatPhone = (phone) => {
  if (!phone) return ''
  const cleaned = phone.toString().replace(/\D/g, '')
  const match = cleaned.match(/^(\d{2})(\d{4,5})(\d{4})$/)
  if (match) {
    return `(${match[1]}) ${match[2]}-${match[3]}`
  }
  return phone
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