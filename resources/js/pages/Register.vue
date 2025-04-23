<template>
    <div class="register-page">
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
      <p v-if="error" style="color:red">{{ error }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { Inertia } from '@inertiajs/inertia'
  
  const name = ref('')
  const email = ref('')
  const password = ref('')
  const role = ref('')
  const error = ref(null)
  
  const register = async () => {
    try {
      const res = await axios.post('/api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        role: role.value
      })
  
      localStorage.setItem('token', res.data.token)
      Inertia.visit('/dashboard') // change to whatever your post-register page is
    } catch (err) {
        console.error("AXIOS ERROR:", err) // <-- Add this
        console.log("AXIOS RESPONSE:", err.response?.data) // <-- Add this

        if (err.response?.data?.errors) {
            error.value = Object.values(err.response.data.errors)[0][0]
        } else {
            error.value = err.response?.data?.message || 'Registration failed'
        }
    }


  }
  </script>
  