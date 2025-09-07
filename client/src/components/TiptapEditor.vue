<template>
  <div class="editor">
    <QuillEditor
    theme="snow"
      ref="quillEditor"
      v-model:content="modelValue" 
            @update:content="handleEditorUpdate"
      :options="editorOptions"
    />

    <!-- 上传加载提示 -->
    <div v-if="isUploading" class="upload-status">
      图片上传中...
    </div>
  </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import { ref, onMounted } from 'vue'
const modelValue = ref('<p>初始内容</p>');

// const modelValue = ref('');

export default {
  components: { QuillEditor },
  emits: ['update:modelValue', 'image-upload'],
  methods: {
    handleEditorUpdate(content) {
      const quill = this.$refs.quillEditor.getQuill();
      const htmlContent = quill.root.innerHTML;
      this.$emit('update:modelValue', htmlContent);
    }
  },
  data() {
    return {
      editorOptions: {
        theme: 'snow',       // 主题：'snow'（工具栏悬浮）或 'bubble'（工具栏气泡）

        modules: {
          toolbar: {
            container: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['clean']  // 清除格式
            ],
            history: {         // 撤销/重做
              delay: 1000,
              maxStack: 500
            },
            handlers: {
              image: function() {
                const quill = this.quillEditor.getQuill();
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = async () => {
                  const file = input.files[0];
                  const url = await new Promise((resolve) => {
                    this.$emit('image-upload', file, resolve);
                  });
                  const range = quill.getSelection(true);
                  quill.insertEmbed(range.index, 'image', url);
                };
                input.click();
              }
            }
          }
        },
        placeholder: '请输入内容...',
        theme: 'snow'
      }
    }
  }
}
</script>

<style scoped>
.editor {
  border: 1px solid #dcdfe6;
  border-radius: 4px;
  padding: 10px;
  min-width: 98%;
  height: 58vh;
  overflow-y: auto;
}

:deep(.ql-container) {
  border: none !important;
  height: calc(100% - 42px);
}

:deep(.ql-editor) {
  height: 100%;
  overflow-y: visible;
}
:deep(.ql-toolbar) {
  border: 1px solid #dcdfe6 !important;
  border-radius: 4px;
  margin-bottom: 10px;
}
</style>