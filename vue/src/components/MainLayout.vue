<template>
  <div class="main-layout">
    <el-menu
      :default-active="activeIndex"
      mode="horizontal"
      router
      class="nav-menu"
    >
      <el-menu-item index="/upgrade-record">升级记录</el-menu-item>
      <el-menu-item index="/review-record">总办复盘记录</el-menu-item>
      <el-menu-item index="/user-management">用户管理</el-menu-item>
    </el-menu>
    <router-view class="content-container" />
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { onMounted } from 'vue'

const route = useRoute()
const activeIndex = route.path

onMounted(async () => {
 
})
</script>

<style scoped>
.main-layout {
  height: 100vh;
  display: flex;
  flex-direction: column;
}
.nav-menu {
  flex-shrink: 0;
}
.content-container {
  flex: 1;
  padding: 20px;
  overflow: auto;
}
</style>