<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()

const navigateTo = (path) => {
  router.push(path)
}
</script>

<template>
  <div class="nav-buttons">
    <button @click="navigateTo('/upgrade')">升级记录</button>
    <button @click="navigateTo('/review')">陈堯朴复盘记录</button>
    <button @click="navigateTo('/user')">用户管理</button>
  </div>
</template>

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
