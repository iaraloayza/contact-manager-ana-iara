<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <div class="flex justify-center mb-6">
          <div class="bg-blue-100 p-3 rounded-full">
            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
        
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Confirme seu Email
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Para finalizar seu cadastro, verifique seu email
        </p>
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-blue-800">
                <strong>Código enviado para:</strong><br>
                <span class="font-medium">{{ email }}</span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Success Message -->
      <div v-if="success" class="bg-green-50 border border-green-200 rounded-md p-4">
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

      <!-- Error Message -->
      <div v-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-red-800">{{ error }}</p>
          </div>
        </div>
      </div>

      <form @submit.prevent="submitForm" class="mt-8 space-y-6">
        <div>
          <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
            Código de verificação (6 dígitos)
          </label>
          <input
            id="code"
            v-model="form.code"
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="6"
            autocomplete="one-time-code"
            required
            class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest font-mono"
            :class="{ 'border-red-500': errors.code }"
            placeholder="000000"
            @input="formatCode"
          />
          <span v-if="errors.code" class="text-red-500 text-xs mt-1">{{ errors.code }}</span>
          
          <div class="mt-2 text-xs text-gray-500 text-center">
            Verifique sua caixa de entrada e spam
          </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-yellow-800">
                <strong>Importante:</strong> Sua conta será criada apenas após a verificação do código. 
                Sem isso, o cadastro não será finalizado.
              </p>
            </div>
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="processing || form.code.length !== 6"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </span>
            {{ processing ? 'Finalizando cadastro...' : 'Finalizar cadastro' }}
          </button>
        </div>

        <div class="text-center space-y-3">
          <p class="text-sm text-gray-600">
            Não recebeu o código?
            <button
              type="button"
              @click="resendCode"
              :disabled="resendDisabled"
              class="font-medium text-blue-600 hover:text-blue-500 disabled:text-gray-400 disabled:cursor-not-allowed"
            >
              {{ resendDisabled ? `Reenviar em ${countdown}s` : 'Reenviar código' }}
            </button>
          </p>
          
          <div class="border-t pt-3">
            <Link
              href="/register"
              class="text-sm text-gray-600 hover:text-gray-900 mr-4"
            >
              ← Voltar ao cadastro
            </Link>
            <Link
              href="/login"
              class="text-sm text-gray-600 hover:text-gray-900"
            >
              Já tenho conta
            </Link>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  email: String,
  success: String,
  error: String,
  errors: Object
})

const processing = ref(false)
const resendDisabled = ref(false)
const countdown = ref(60)
let countdownInterval = null

const form = reactive({
  code: ''
})

const formatCode = (event) => {
  // Remove caracteres não numéricos
  const value = event.target.value.replace(/\D/g, '')
  form.code = value.substring(0, 6)
}

const submitForm = () => {
  processing.value = true
  
  router.post('/2fa/verify', form, {
    onFinish: () => {
      processing.value = false
    }
  })
}

const resendCode = () => {
  router.post('/2fa/resend', {}, {
    onSuccess: () => {
      startCountdown()
    }
  })
}

const startCountdown = () => {
  resendDisabled.value = true
  countdown.value = 60
  
  countdownInterval = setInterval(() => {
    countdown.value--
    if (countdown.value <= 0) {
      resendDisabled.value = false
      clearInterval(countdownInterval)
    }
  }, 1000)
}

onMounted(() => {
  startCountdown()
})

onUnmounted(() => {
  if (countdownInterval) {
    clearInterval(countdownInterval)
  }
})
</script>