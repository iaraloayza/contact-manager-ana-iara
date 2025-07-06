<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Header/Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
              </div>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">Contatos</h1>
              <p class="text-sm text-gray-600">Gerencie seus contatos pessoais</p>
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <div class="relative">
              <button
                @click="toggleUserMenu"
                class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md p-2"
              >
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
              
              <!-- Dropdown Menu -->
              <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 ring-1 ring-black ring-opacity-5">
                <button
                  @click="logout"
                  class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Success Message -->
      <div v-if="success" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ success }}</p>
          </div>
        </div>
      </div>

      <!-- Main Content Card -->
      <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-2xl font-bold text-white">Seus Contatos</h2>
              <p class="text-blue-100 mt-1">Organize e gerencie sua lista de contatos</p>
            </div>
            <button
              @click="openCreateModal"
              class="bg-white hover:bg-gray-50 text-blue-600 px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center space-x-2"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              <span>Novo Contato</span>
            </button>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="contacts.data.length === 0" class="px-6 py-16 text-center">
          <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
              <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum contato encontrado</h3>
          <p class="text-gray-600 mb-6">Comece adicionando seu primeiro contato à lista.</p>
          <button
            @click="openCreateModal"
            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105"
          >
            Criar Primeiro Contato
          </button>
        </div>
        
        <!-- Contacts Table -->
        <div v-else class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Nome
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Email
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Telefone
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Ações
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10">
                      <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ contact.name.charAt(0).toUpperCase() }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-semibold text-gray-900">{{ contact.name }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ contact.email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatPhone(contact.phone) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="editContact(contact)"
                      class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-1 rounded-md transition-colors flex items-center space-x-1"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      <span>Editar</span>
                    </button>
                    <button
                      @click="deleteContact(contact)"
                      class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-md transition-colors flex items-center space-x-1"
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
          <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
              <div class="flex-1 flex justify-between sm:hidden">
                <Link
                  v-if="contacts.prev_page_url"
                  :href="contacts.prev_page_url"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                  Anterior
                </Link>
                <Link
                  v-if="contacts.next_page_url"
                  :href="contacts.next_page_url"
                  class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                >
                  Próximo
                </Link>
              </div>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ contacts.from }}</span> a <span class="font-medium">{{ contacts.to }}</span> de <span class="font-medium">{{ contacts.total }}</span> resultados
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <Link
                      v-if="contacts.prev_page_url"
                      :href="contacts.prev_page_url"
                      class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
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
                            ? 'bg-blue-50 border-blue-500 text-blue-600'
                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                          'relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors'
                        ]"
                      >
                        {{ page }}
                      </Link>
                      <span v-else class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                        ...
                      </span>
                    </template>
                    
                    <Link
                      v-if="contacts.next_page_url"
                      :href="contacts.next_page_url"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors"
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
  if (showUserMenu.value && !event.target.closest('.relative')) {
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