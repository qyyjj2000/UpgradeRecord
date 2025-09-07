import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'


import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css' // 必选雪花主题样式[3,7](@ref)

const app = createApp(App)
app.component('QuillEditor', QuillEditor) // 注册后所有组件可用 <quill-editor> 标签[7,8](@ref)



app.use(router)
app.use(ElementPlus)
app.mount('#app')
