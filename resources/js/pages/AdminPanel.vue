<template>
    <div>
      <h1>Admin Panel</h1>
      <ul>
        <li v-for="user in users" :key="user.id">{{ user.name }} - {{ user.email }}</li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  const users = ref([])
  
  onMounted(() => {
    const token = localStorage.getItem('token')
    if (!token) {
      console.error('No token found')
      return
    }

    axios.get('/users', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
      .then(res => {
        users.value = res.data
      })
      .catch(err => {
        console.error(err)
      })
  })

  </script>
  