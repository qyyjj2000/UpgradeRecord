import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/upgrade',
    name: 'UpgradeRecord',
    component: () => import('../views/UpgradeRecord.vue')
  },
  {
    path: '/review',
    name: 'ReviewRecord',
    component: () => import('../views/ReviewRecord.vue')
  },
  {
    path: '/user',
    name: 'UserManagement',
    component: () => import('../views/UserManagement.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router