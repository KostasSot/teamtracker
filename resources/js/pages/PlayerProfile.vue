<template>
    <div>
      <h1>My Profile</h1>
      <p><strong>Name:</strong> {{ player.name }}</p>
      <p><strong>Email:</strong> {{ player.email }}</p>
      <p><strong>Age:</strong> {{ player.age }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  const player = ref({})
  
  onMounted(() => {
    const token = localStorage.getItem('token')
    if (!token) {
      console.error('No token found')
      return
    }

    axios.get('/players/1/card', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
      .then(res => {
        player.value = res.data
      })
      .catch(err => {
        console.error(err)
      })
})



  </script>
  