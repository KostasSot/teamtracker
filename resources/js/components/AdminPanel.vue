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
    axios.get('/users')
      .then(res => {
        users.value = res.data
      })
      .catch(err => {
        console.error(err)
      })
  })
  </script>
  