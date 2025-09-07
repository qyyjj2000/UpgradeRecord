import { createRouter, createWebHistory,createWebHashHistory  } from 'vue-router'
import MainLayout from '@/components/MainLayout.vue'
import UpgradeRecord from '@/components/UpgradeRecord.vue'
import ReviewRecord from '@/components/ReviewRecord.vue'
import UserManagement from '@/components/UserManagement.vue'

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      component: MainLayout,
      children: [
        { path: 'upgrade-record', component: UpgradeRecord },
        { path: 'review-record', component: ReviewRecord },
        { path: 'user-management', component: UserManagement },
        { path: '', redirect: 'upgrade-record' }
      ]
    }
  ]
})