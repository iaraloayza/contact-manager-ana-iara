<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <!-- <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div> -->
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
    <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-4000"></div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
      <!-- Header -->
      <div class="text-center">
        <div class="flex justify-center mb-6">
          <div class="w-20 h-20 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-300">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
          </div>
        </div>
        <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
          Contact Manager
        </h1>
        <h2 class="text-xl font-semibold text-gray-200 mb-4">
          Junte-se a nós!
        </h2>
        <p class="text-gray-300 mb-2">
          Crie sua conta e comece a organizar seus contatos
        </p>
        <p class="text-sm text-gray-400">
          Já tem uma conta?
          <Link href="/login" class="font-semibold text-cyan-400 hover:text-cyan-300 transition-colors underline decoration-2 underline-offset-4">
            Entre agora
          </Link>
        </p>
      </div>

      <!-- Register Card -->
      <div class="bg-white/10 backdrop-blur-xl shadow-2xl rounded-2xl overflow-hidden border border-white/20">
        <!-- Error Message -->
        <div v-if="error" class="bg-red-500/20 border-b border-red-400/30 p-4 backdrop-blur-sm">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-red-300">{{ error }}</p>
            </div>
          </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="p-8 space-y-6">
          <div class="space-y-5">
            <div>
              <label for="name" class="block text-sm font-semibold text-gray-200 mb-2">
                Nome completo
              </label>
              <div class="relative">
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  autocomplete="name"
                  required
                  class="appearance-none relative block w-full pl-12 pr-3 py-4 border border-white/20 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent bg-white/5 backdrop-blur-sm sm:text-sm transition-all duration-200"
                  :class="{ 'border-red-400/50 focus:ring-red-400': errors.name }"
                  placeholder="Digite seu nome completo"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
              </div>
              <span v-if="errors.name" class="text-red-400 text-sm mt-1 block">{{ errors.name }}</span>
            </div>

            <div>
              <label for="email" class="block text-sm font-semibold text-gray-200 mb-2">
                Email
              </label>
              <div class="relative">
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  autocomplete="email"
                  required
                  class="appearance-none relative block w-full pl-12 pr-3 py-4 border border-white/20 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent bg-white/5 backdrop-blur-sm sm:text-sm transition-all duration-200"
                  :class="{ 'border-red-400/50 focus:ring-red-400': errors.email }"
                  placeholder="seu@email.com"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                  </svg>
                </div>
              </div>
              <span v-if="errors.email" class="text-red-400 text-sm mt-1 block">{{ errors.email }}</span>
            </div>

            <div>
              <label for="password" class="block text-sm font-semibold text-gray-200 mb-2">
                Senha
              </label>
              <div class="relative">
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  autocomplete="new-password"
                  required
                  class="appearance-none relative block w-full pl-12 pr-3 py-4 border border-white/20 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent bg-white/5 backdrop-blur-sm sm:text-sm transition-all duration-200"
                  :class="{ 'border-red-400/50 focus:ring-red-400': errors.password }"
                  placeholder="••••••••"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>
                </div>
              </div>
              <span v-if="errors.password" class="text-red-400 text-sm mt-1 block">{{ errors.password }}</span>
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-200 mb-2">
                Confirmar senha
              </label>
              <div class="relative">
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  autocomplete="new-password"
                  required
                  class="appearance-none relative block w-full pl-12 pr-3 py-4 border border-white/20 placeholder-gray-400 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent bg-white/5 backdrop-blur-sm sm:text-sm transition-all duration-200"
                  placeholder="••••••••"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <div>
            <button
              type="submit"
              :disabled="processing"
              class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-600 hover:from-cyan-600 hover:via-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-400 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl"
            >
              <span v-if="processing" class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </span>
              <span v-else class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-white group-hover:text-cyan-100 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
              </span>
              {{ processing ? 'Criando conta...' : 'Criar minha conta' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Footer -->
      <div class="text-center">
        <p class="text-gray-400 text-sm">
          © 2025 Contact Manager. Gerencie seus contatos com estilo.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  error: String,
  errors: Object
})

const processing = ref(false)

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const submitForm = () => {
  processing.value = true
  
  router.post('/register', form, {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<style scoped>
.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}
</style>