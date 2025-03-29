<script setup>
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
  <div class="app-container">
    <HelloWorld msg="Vite + Vue" />
    <router-view />
  </div>
</template>

<style scoped>
.app-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  width: 100%;
}

.app-container > HelloWorld {
  height: 5%;
}

.app-container > router-view {
  height: 95%;
}

.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
