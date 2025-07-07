<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 bg-pattern opacity-30"></div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-blue-200 to-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute top-40 right-20 w-32 h-32 bg-gradient-to-r from-purple-200 to-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    <div class="absolute bottom-20 left-1/2 w-32 h-32 bg-gradient-to-r from-cyan-200 to-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
    
    <!-- Header -->
    <Header 
      :user="user" 
      :unread-count="0" 
      :is-notifications-page="false" 
    />

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
      <!-- Success/Error Messages -->
      <div v-if="$page.props.flash.success" class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ $page.props.flash.success }}</p>
          </div>
        </div>
      </div>

      <div v-if="$page.props.flash.error" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-red-800">{{ $page.props.flash.error }}</p>
          </div>
        </div>
      </div>

      <!-- Profile Header -->
      <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-slate-200/50 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-10">
          <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-3xl font-bold text-white tracking-tight">Meu Perfil</h2>
              <p class="text-blue-100 mt-2 text-lg">Gerencie suas informações pessoais</p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profile Information -->
        <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-slate-200/50">
          <div class="px-8 py-6 border-b border-slate-200/50">
            <h3 class="text-xl font-bold text-slate-800">Informações Pessoais</h3>
            <p class="text-slate-600 mt-1">Atualize seus dados pessoais</p>
          </div>
          
          <form @submit.prevent="updateProfile" class="p-8">
            <div class="space-y-6">
              <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nome Completo</label>
                <input
                  v-model="profileForm.name"
                  type="text"
                  id="name"
                  class="w-full px-4 py-3 bg-white/60 backdrop-blur-sm border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                  placeholder="Seu nome completo"
                  required
                />
                <div v-if="$page.props.errors.name" class="mt-2 text-red-600 text-sm">
                  {{ $page.props.errors.name }}
                </div>
              </div>

              <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input
                  v-model="profileForm.email"
                  type="email"
                  id="email"
                  class="w-full px-4 py-3 bg-white/60 backdrop-blur-sm border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                  placeholder="seu@email.com"
                  required
                />
                <div v-if="$page.props.errors.email" class="mt-2 text-red-600 text-sm">
                  {{ $page.props.errors.email }}
                </div>
              </div>

              <div class="flex justify-end">
                <button
                  type="submit"
                  :disabled="profileForm.processing"
                  class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ profileForm.processing ? 'Salvando...' : 'Salvar Alterações' }}
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Password Change -->
        <div class="bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-slate-200/50">
          <div class="px-8 py-6 border-b border-slate-200/50">
            <h3 class="text-xl font-bold text-slate-800">Alterar Senha</h3>
            <p class="text-slate-600 mt-1">Mantenha sua conta segura</p>
          </div>
          
          <form @submit.prevent="updatePassword" class="p-8">
            <div class="space-y-6">
              <div>
                <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-2">Senha Atual</label>
                <input
                  v-model="passwordForm.current_password"
                  type="password"
                  id="current_password"
                  class="w-full px-4 py-3 bg-white/60 backdrop-blur-sm border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                  placeholder="Sua senha atual"
                  required
                />
                <div v-if="$page.props.errors.current_password" class="mt-2 text-red-600 text-sm">
                  {{ $page.props.errors.current_password }}
                </div>
              </div>

              <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Nova Senha</label>
                <input
                  v-model="passwordForm.password"
                  type="password"
                  id="password"
                  class="w-full px-4 py-3 bg-white/60 backdrop-blur-sm border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                  placeholder="Nova senha (mínimo 8 caracteres)"
                  required
                />
                <div v-if="$page.props.errors.password" class="mt-2 text-red-600 text-sm">
                  {{ $page.props.errors.password }}
                </div>
              </div>

              <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirmar Nova Senha</label>
                <input
                  v-model="passwordForm.password_confirmation"
                  type="password"
                  id="password_confirmation"
                  class="w-full px-4 py-3 bg-white/60 backdrop-blur-sm border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                  placeholder="Confirme a nova senha"
                  required
                />
              </div>

              <div class="flex justify-end">
                <button
                  type="submit"
                  :disabled="passwordForm.processing"
                  class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ passwordForm.processing ? 'Alterando...' : 'Alterar Senha' }}
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Delete Account Section -->
        <div class="mt-12 bg-white/70 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-red-200">
          <div class="px-8 py-6 border-b border-red-200 bg-red-100/40">
            <h3 class="text-xl font-bold text-red-700">Excluir Conta</h3>
            <p class="text-red-600 mt-1">Esta ação é irreversível. Todos os seus dados serão permanentemente apagados.</p>
          </div>

          <div class="p-8 flex justify-end">
            <button
              @click="showDeleteModal = true"
              class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg"
            >
              Excluir Conta
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div
    v-if="showDeleteModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
      <h2 class="text-xl font-bold text-red-700 mb-4">Confirmar Exclusão</h2>
      <p class="text-slate-700 mb-6">Tem certeza de que deseja excluir sua conta? Esta ação não poderá ser desfeita.</p>
      
      <form @submit.prevent="deleteAccount">
        <div class="space-y-4">
          <input
            v-model="deleteForm.password"
            type="password"
            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
            placeholder="Digite sua senha para confirmar"
            required
          />
          <div v-if="$page.props.errors.delete_current_password" class="text-red-600 text-sm">
            {{ $page.props.errors.delete_current_password }}
          </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
          <button
            type="button"
            @click="showDeleteModal = false"
            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-slate-800 font-semibold"
          >
            Cancelar
          </button>
          <button
            type="submit"
            :disabled="deleteForm.processing"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold disabled:opacity-50"
          >
            {{ deleteForm.processing ? 'Excluindo...' : 'Confirmar Exclusão' }}
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'

const props = defineProps({
  user: Object
})

const profileForm = reactive({
  name: props.user.name,
  email: props.user.email,
  processing: false
})

const passwordForm = reactive({
  current_password: '',
  password: '',
  password_confirmation: '',
  processing: false
})

const updateProfile = () => {
  profileForm.processing = true
  
  router.put('/profile', {
    name: profileForm.name,
    email: profileForm.email
  }, {
    preserveScroll: true,
    onFinish: () => {
      profileForm.processing = false
    }
  })
}

const updatePassword = () => {
  passwordForm.processing = true
  
  router.put('/profile/password', {
    current_password: passwordForm.current_password,
    password: passwordForm.password,
    password_confirmation: passwordForm.password_confirmation
  }, {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.current_password = ''
      passwordForm.password = ''
      passwordForm.password_confirmation = ''
    },
    onFinish: () => {
      passwordForm.processing = false
    }
  })
}

const showDeleteModal = ref(false)

const deleteForm = reactive({
  password: '',
  processing: false
})

const deleteAccount = () => {
  deleteForm.processing = true

  router.delete('/profile', {
    data: {
      password: deleteForm.password
    },
    onFinish: () => {
      deleteForm.processing = false
      deleteForm.password = ''
    },
    onError: () => {
      showDeleteModal.value = true // Reabrir modal se erro
    }
  })
}
</script>

<style scoped>
.bg-pattern {
  background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23000000" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
}
</style>