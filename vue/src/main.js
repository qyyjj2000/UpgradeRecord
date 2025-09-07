import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import installElementPlus from './plugins/element'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css' // 必选雪花主题样式[3,7](@ref)
const app = createApp(App)
installElementPlus(app)
app.use(router)
app.component('QuillEditor', QuillEditor) // 注册后所有组件可用 <QuillEditor> 标签

app.mount('#app')
console.log('Environment:', import.meta.env.MODE);

app.config.errorHandler = (err, vm, info) => {
    console.error('[Global Error]', err, info);
  };