import { createRouter, createWebHistory } from 'vue-router'
import AdminPanel from '../components/AdminPanel.vue'
import PlayerProfile from '../components/PlayerProfile.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/admin', component: AdminPanel, meta: { requiresAuth: true } },
  { path: '/player', component: PlayerProfile, meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const user = localStorage.getItem('user')
  if (to.meta.requiresAuth && !user) {
    return next('/login')
  }
  next()
})

export default router
