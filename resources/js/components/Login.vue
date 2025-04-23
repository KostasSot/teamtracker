<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  const email = ref('')
  const password = ref('')
  
  const login = async () => {
    try {
      await axios.get('/sanctum/csrf-cookie') // required!
      const res = await axios.post('/login', { email: email.value, password: password.value })
      localStorage.setItem('user', JSON.stringify(res.data.user))
      router.push('/admin')
    } catch (err) {
      alert('Login failed')
    }
  }
  </script>
  