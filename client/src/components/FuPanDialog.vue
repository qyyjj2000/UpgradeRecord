<template>
  <el-dialog :title="`${currentRow?.country || ''}复盘记录`" v-model="dialogVisible" width="90%" style="height: 80%;margin-top: 5%;">
    <el-form :model="formData" label-width="80px">
      <el-form-item label="复盘目的">
        <el-input v-model="formData.purpose" placeholder="请输入复盘目的" />
      </el-form-item>
      
      <el-form-item label="复盘时间">
        <el-date-picker
          v-model="formData.review_time"
          type="datetime"
          placeholder="选择复盘时间"
          value-format="YYYY-MM-DD HH:mm:ss"
        />
      </el-form-item>
      
      <el-form-item label="复盘内容">
        <QuillEditor
          v-model:content="formData.content"
          theme="snow"
          @image-upload="handleImageUpload"
          :options="{ modules: { toolbar: [['image']] } }"
        />
        
      </el-form-item>
    </el-form>
    
    <template #footer>
      <el-button @click="dialogVisible = false">取消</el-button>
      <el-button type="primary" @click="submitForm">提交</el-button>
    </template>
  </el-dialog>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import api from '../api/index.js'
import { ref } from 'vue';
const currentRow = ref({})
const dialogVisible = ref(false)
const formData = ref({
  purpose: '',
  review_time: '',
  content: ''
})
export default {
  components: { QuillEditor },
  props: {
    row: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  setup(props) {
    // 初始化时处理props数据
    if (props.row) {
      formData.value.content = typeof props.row.content === 'object' 
        ? JSON.stringify(props.row.content) 
        : props.row.content || '';
    }

    return {
      currentRow,
      dialogVisible,
      formData
    }
  },
  methods: {
    open(row) {
        currentRow.value = row || {};
        this.formData = {
          purpose: row?.purpose || '',
          review_time: row?.review_time || '',
          content: typeof row?.content === 'object' ? JSON.stringify(row?.content) : (row?.content || '')
        };
        this.dialogVisible = true;
    },
    async handleImageUpload(file) {
      try {
        const formData = new FormData()
        formData.append('image', file)
        const response = await api.post('/upload.php?action=upload_image', formData)
        let url = response.data.url
        console.log(url)
        return url;
      } catch (error) {
        this.$message.error('图片上传失败')
        return null
      }
    },
    submitForm() {
      const submitData = {
        ...this.formData,
        content: typeof this.formData.content === 'object' ? JSON.stringify(this.formData.content) : this.formData.content,
        record_id: this.currentRow?.id || ''
      }
      this.$emit('submit', submitData)
      dialogVisible.value = false;
    }
  }
}
</script>

<style scoped>
.el-form-item {
  margin-bottom: 20px;
}

.el-input, .el-date-editor {
  width: 100%;
}


::v-deep .el-dialog {
  max-height: 80vh !important;
  overflow: auto;
  display: flex;
  flex-direction: column;
}

::v-deep .el-dialog__body {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
}

.submit-button {
  margin-top: auto;
  padding-top: 20px;
}
</style>