<template>
    <div class="login-page">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
      <p v-if="error" style="color: red;">{{ error }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { Inertia } from '@inertiajs/inertia'
  
  const email = ref('')
  const password = ref('')
  const error = ref(null)
  
  const login = async () => {
    try {
      console.log('Sending login request...')
      const res = await axios.post('/login', {
        email: email.value,
        password: password.value
      })
      localStorage.setItem('token', res.data.token)
      Inertia.visit('/dashboard') // change to whatever page you want next
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed'
    }
  }
  </script>
  