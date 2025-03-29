<template>
  <el-tabs v-model="activeTab" @tab-click="handleTabClick">
    <el-tab-pane label="升级记录" name="upgrade" />
    <el-tab-pane label="陈堯朴复盘记录" name="review" />
    <el-tab-pane label="用户管理" name="user" />
  </el-tabs>
</template>
<script setup>

import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'

const activeTab = ref('upgrade')
const router = useRouter()

watch(() => router.currentRoute.value.path, (newPath) => {
  activeTab.value = newPath.slice(1) || 'upgrade'
})

const handleTabClick = (tab) => {
  router.push(`/${tab.paneName}`)
}
</script>
<style scoped>
.nav-buttons {
  display: flex;
  gap: 1rem;
  margin-bottom: 0.5rem;
}

.nav-buttons button {
  padding: 0.5rem 1rem;
  background: #42b883;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.nav-buttons button:hover {
  background: #3aa876;
}
</style>
