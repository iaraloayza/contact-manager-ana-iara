<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-20"></div>

    <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
    <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-4000"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">
      <div class="text-center">
        <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">Redefinir Senha</h1>
        <p class="text-gray-300">Insira sua nova senha</p>
      </div>

      <div class="bg-white/10 backdrop-blur-xl shadow-2xl rounded-2xl overflow-hidden border border-white/20">
        <div v-if="errors.email" class="bg-red-500/20 border-b border-red-400/30 p-4 backdrop-blur-sm">
          <p class="text-sm text-red-300 font-medium">{{ errors.email }}</p>
        </div>

        <form @submit.prevent="submit" class="p-8 space-y-6">
          <input type="hidden" v-model="form.token" />

          <div>
            <label class="text-sm font-semibold text-gray-200 block mb-1">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-4 py-3 rounded-xl bg-white/5 text-white border border-white/20 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400"
              required
            />
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-200 block mb-1">Nova Senha</label>
            <input
              v-model="form.password"
              type="password"
              class="w-full px-4 py-3 rounded-xl bg-white/5 text-white border border-white/20 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400"
              required
            />
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-200 block mb-1">Confirmar Senha</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              class="w-full px-4 py-3 rounded-xl bg-white/5 text-white border border-white/20 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400"
              required
            />
          </div>

          <div>
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 text-white font-bold py-3 rounded-xl hover:from-green-600 hover:to-cyan-600 transition duration-300 transform hover:scale-105 shadow-xl">
              Redefinir senha
            </button>
          </div>
        </form>
      </div>

      <div class="text-center">
        <Link href="/login" class="text-sm text-cyan-300 hover:underline">Voltar para login</Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  token: String,
  errors: {
    type: Object,
    default: () => ({})
  }
})

const form = reactive({
  email: '',
  password: '',
  password_confirmation: '',
  token: props.token
})

function submit() {
  router.post('/reset-password', form)
}
</script>

<style scoped>
.bg-pattern {
  background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
}
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
</style>