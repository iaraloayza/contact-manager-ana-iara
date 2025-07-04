<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-gray-900">
            {{ isEdit ? 'Editar Contato' : 'Novo Contato' }}
          </h3>
          <button
            @click="$emit('close')"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Nome -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.name }"
              >
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.email }"
              >
              <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
            </div>

            <!-- Telefone -->
            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
              <input
                id="phone"
                v-model="form.phone"
                type="tel"
                required
                placeholder="(41) 98899-4422"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                :class="{ 'border-red-500': errors.phone }"
                @input="formatPhoneInput"
              >
              <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
            </div>
          </div>

          <div class="flex justify-end space-x-3 mt-6">
            <button
              type="button"
              @click="$emit('close')"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Cancelar
            </button>
            <button
              type="submit"
              :disabled="processing"
              class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
              {{ processing ? 'Salvando...' : (isEdit ? 'Atualizar' : 'Criar') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  contact: Object,
  isEdit: Boolean
})

const emit = defineEmits(['close', 'submit'])

const page = usePage()
const processing = ref(false)

const form = ref({
  name: '',
  email: '',
  phone: ''
})

const errors = computed(() => page.props.errors || {})

// Função para limpar erros quando o modal é fechado
const clearErrors = () => {
  if (page.props.errors) {
    page.props.errors = {}
  }
}

// Preencher form quando for edição
const initializeForm = () => {
  if (props.contact && props.isEdit) {
    form.value = {
      name: props.contact.name || '',
      email: props.contact.email || '',
      phone: formatPhone(props.contact.phone) || ''
    }
  } else {
    form.value = {
      name: '',
      email: '',
      phone: ''
    }
  }
}

// Inicializar form quando o componente for montado
onMounted(() => {
  initializeForm()
})

// Observar mudanças no contato
watch(() => props.contact, () => {
  initializeForm()
}, { deep: true })

// Limpar erros quando o modal for fechado
watch(() => props.contact, (newContact) => {
  if (!newContact) {
    clearErrors()
  }
})

const formatPhone = (phone) => {
  if (!phone) return ''
  const cleaned = phone.toString().replace(/\D/g, '')
  const match = cleaned.match(/^(\d{2})(\d{4,5})(\d{4})$/)
  if (match) {
    return `(${match[1]}) ${match[2]}-${match[3]}`
  }
  return phone
}

const formatPhoneInput = (event) => {
  let value = event.target.value.replace(/\D/g, '')
  
  // Limitar a 11 dígitos
  if (value.length > 11) {
    value = value.slice(0, 11)
  }
  
  if (value.length <= 10) {
    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3')
  } else {
    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
  }
  
  form.value.phone = value
}

const submitForm = () => {
  if (processing.value) return
  
  console.log('Enviando formulário...')
  console.log('Dados do form:', form.value)
  
  processing.value = true
  
  const formData = {
    name: form.value.name.trim(),
    email: form.value.email.trim(),
    phone: form.value.phone
  }
  
  console.log('Dados formatados:', formData)
  
  // Força o processamento após um pequeno delay
  setTimeout(() => {
    emit('submit', formData)
    
    // Reset processing state after emission
    setTimeout(() => {
      processing.value = false
    }, 2000)
  }, 100)
}
</script>