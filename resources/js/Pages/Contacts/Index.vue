<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">Contatos</h1>
              <p class="text-sm text-gray-600">Gerencie seus contatos</p>
            </div>
            <button
              @click="openCreateModal"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors"
            >
              Novo Contato
            </button>
          </div>
        </div>
      </div>

      <!-- Success Message -->
      <div v-if="success" class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
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

      <!-- Contacts Table -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div v-if="contacts.data.length === 0" class="px-6 py-12 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum contato</h3>
          <p class="mt-1 text-sm text-gray-500">Comece criando um novo contato.</p>
        </div>
        
        <div v-else>
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nome
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Email
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Telefone
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Ações
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ contact.name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ contact.email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatPhone(contact.phone) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button
                    @click="editContact(contact)"
                    class="text-blue-600 hover:text-blue-900 mr-3"
                  >
                    Editar
                  </button>
                  <button
                    @click="deleteContact(contact)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Excluir
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="contacts.prev_page_url"
                :href="contacts.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Anterior
              </Link>
              <Link
                v-if="contacts.next_page_url"
                :href="contacts.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
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
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
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
                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
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
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
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
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ContactModal from './ContactModal.vue'
import ConfirmModal from './ConfirmModal.vue'

const props = defineProps({
  contacts: Object,
  success: String
})

const showModal = ref(false)
const showDeleteModal = ref(false)
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

const openCreateModal = () => {
  selectedContact.value = null
  isEdit.value = false
  showModal.value = true
}

const editContact = (contact) => {
  selectedContact.value = { ...contact } // Criar uma cópia do contato
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
    console.log('Tentando excluir contato:', contactToDelete.value.id)
    router.delete(`/contacts/${contactToDelete.value.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        console.log('Contato excluído com sucesso')
        closeDeleteModal()
      },
      onError: (errors) => {
        console.error('Erro ao excluir contato:', errors)
      },
      onFinish: () => {
        console.log('Requisição de exclusão finalizada')
      }
    })
  } else {
    console.error('ID do contato não encontrado')
  }
}

const handleSubmit = (formData) => {
  console.log('Dados do formulário:', formData)
  console.log('É edição?', isEdit.value)
  console.log('Contato selecionado:', selectedContact.value)
  
  if (isEdit.value && selectedContact.value?.id) {
    console.log('Tentando atualizar contato:', selectedContact.value.id)
    router.put(`/contacts/${selectedContact.value.id}`, formData, {
      preserveScroll: true,
      onSuccess: () => {
        console.log('Contato atualizado com sucesso')
        closeModal()
      },
      onError: (errors) => {
        console.error('Erro ao atualizar contato:', errors)
      },
      onFinish: () => {
        console.log('Requisição de atualização finalizada')
      }
    })
  } else {
    console.log('Tentando criar novo contato')
    router.post('/contacts', formData, {
      preserveScroll: true,
      onSuccess: () => {
        console.log('Contato criado com sucesso')
        closeModal()
      },
      onError: (errors) => {
        console.error('Erro ao criar contato:', errors)
      },
      onFinish: () => {
        console.log('Requisição de criação finalizada')
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
</script>