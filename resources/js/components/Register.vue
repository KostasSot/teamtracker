<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="register">
        <input v-model="name" type="text" placeholder="Name" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <select v-model="role" required>
          <option disabled value="">Select role</option>
          <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="player">Player</option>
        </select>
        <button type="submit">Register</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  
  const name = ref('')
  const email = ref('')
  const password = ref('')
  const role = ref('')
  
  const register = async () => {
    try {
      console.log('[Register] Getting CSRF cookie...')
      await axios.get('/sanctum/csrf-cookie') // 👈 REQUIRED first
  
      console.log('[Register] Sending register POST...')

      await axios.get('/sanctum/csrf-cookie')
      console.log('Cookies:', document.cookie)


      const res = await axios.post('/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        role: role.value
      })
  
      console.log('[Register] Success:', res.data)
      localStorage.setItem('user', JSON.stringify(res.data.user))
      router.push('/login')
    } catch (err) {
      console.error('[Register] Error:', err)
      alert('Registration failed: ' + (err.response?.data?.message || 'CSRF token mismatch or server error'))
    }
  }
  </script>
  