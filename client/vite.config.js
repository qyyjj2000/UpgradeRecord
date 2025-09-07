import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'



// https://vite.dev/config/
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

export default defineConfig({
  plugins: [
    vue(),
    Components({
      resolvers: [
        ElementPlusResolver({
          importStyle: 'compacted'
        })
      ]
    }),
  ],
})
