<template>
  <div class="container">
    <!-- 查询区域 -->
    <div class="search-area">
      <el-button type="primary" @click="openDialog('create')">新增记录</el-button>
      <el-date-picker
        v-model="searchParams.start_time"
        type="datetime"
        placeholder="选择开始时间"
        value-format="YYYY-MM-DD HH:mm:ss"
      />
      <el-date-picker
        v-model="searchParams.end_time"
        type="datetime"
        placeholder="选择结束时间"
        value-format="YYYY-MM-DD HH:mm:ss"
      />
      <el-select v-model="searchParams.country" style="width: 120px;" placeholder="选择国家">
        <el-option
          v-for="country in countryOptions"
          :key="country.value"
          :label="country.label"
          :value="country.value"
        />
      </el-select>
      <el-button type="primary" @click="fetchRecords">查询</el-button>
      <el-button @click="copyYesterdayContent">复制昨日上线内容</el-button>
    </div>

    <!-- 数据表格 -->
    <el-table :data="tableData" border>
      <el-table-column prop="country" label="国家" header-align="center" align="center" width="100" :formatter="formatCountry"/>
      <el-table-column prop="content" label="升级内容" header-align="center">
        <template #default="scope">
          <div style="white-space: pre-line">{{ scope.row.content }}</div>
        </template>
      </el-table-column>
      <el-table-column prop="type" label="类型" header-align="center" align="center" width="90"/>
      <el-table-column prop="platform" label="平台" header-align="center" align="center" width="60"/>
      <el-table-column prop="updater" label="研发" header-align="center" align="center" width="100" show-overflow-tooltip/>
      <el-table-column prop="tester" label="测试" header-align="center" align="center" width="100" show-overflow-tooltip/>
      <el-table-column prop="is_review" label="复盘" header-align="center" align="center" width="100" show-overflow-tooltip :formatter="formatReview"/>

      <el-table-column prop="remark" label="备注" header-align="center" align="center" width="100" show-overflow-tooltip/>

      <el-table-column prop="update_time" label="更新时间" header-align="center" align="center" width="150"/>
      <el-table-column label="操作" width="150" header-align="center" align="center">
        <template #default="scope">
          <el-button size="small" @click="openDialog('edit', scope.row)">编辑</el-button>
          <el-button size="small" type="danger" @click="handleDelete(scope.row)">删除</el-button>
          <el-button size="small" style="margin-top: 3px;" v-if="scope.row.is_review == 1" @click="review(scope.row); currentRow = scope.row">查看复盘</el-button>

        </template>
      </el-table-column>
    </el-table>

    <!-- 弹窗表单 -->
    <el-dialog :title="dialogTitle" v-model="dialogVisible">
      <el-form :model="formData" :rules="formRules" ref="formRef" label-width="80px">
        <el-form-item label="国家" prop="country" l>
          <el-select v-model="formData.country">
            <el-option
              v-for="country in countryOptions"
              :key="country.value"
              :label="country.label"
              :value="country.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="类型" prop="type">
          <el-select v-model="formData.type">
            <el-option
              v-for="type in typeOptions"
              :key="type.value"
              :label="type.label"
              :value="type.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="平台" prop="platform">
          <el-select v-model="formData.platform">
            <el-option
              v-for="platform in platformOptions"
              :key="platform.value"
              :label="platform.label"
              :value="platform.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="升级内容" prop="content">
          <el-input
            v-model="formData.content"
            type="textarea"
            :rows="4"
            placeholder="请输入升级内容"
          />
        </el-form-item>
        <el-form-item label="复盘" prop="platform">
          <el-select v-model="formData.is_review">
            <el-option
              v-for="platform in is_review_options"
              :key="platform.value"
              :label="platform.label"
              :value="platform.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item label="测试人员" prop="tester">
          <el-select 
            v-model="formData.tester"
            multiple
            filterable
            placeholder="请选择测试人员">
            <el-option
              v-for="tester in testers"
              :key="tester.id"
              :label="tester.username"
              :value="tester.username"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="更新人" prop="updater">
          <el-select
            v-model="formData.updater"
            multiple
            filterable
            placeholder="请选择更新人">
            <el-option
              v-for="dev in develops"
              :key="dev.id"
              :label="dev.username"
              :value="dev.username"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="formData.remark" type="textarea" />
        </el-form-item>
      </el-form>
      <template #footer>
        <el-button @click="dialogVisible = false">取消</el-button>
        <el-button type="primary" @click="submitForm">确认</el-button>
      </template>
    </el-dialog>

    <FuPanDialog ref="fupanDialog" :row="currentRow" />

  </div>
</template>

<script>
import api from '../api/index.js'
import FuPanDialog from '../components/FuPanDialog.vue'

export default {
  name: 'UpgradeRecord',
  components: {
    FuPanDialog
  },
  computed: {
    dialogTitle() {
      return this.dialogType === 'create' ? '新增记录' : '编辑记录'
    }
  },
  data() {
    return {
      reviewDialogVisible: false,
      tableData: [],
      develops: [],
      testers: [],
      currentRow: {},
      dialogVisible: false,
      dialogType: 'create',
      searchParams: {
        start_time: '',
        end_time: '',
        country: ''
      },
      formData: {
        country: '',
        content: '',
        type: '',
        platform: '',
        tester: [],
        updater: [],
        update_time: '',
        remark: ''
      },
      formRules: {
        country: [{ required: true, message: '请选择国家', trigger: 'change' }],
        content: [{ 
          required: true, 
          message: '请输入升级内容', 
          trigger: 'change',
          type: 'string',
          min: 1 
        }],
        type: [{ required: true, message: '请选择类型', trigger: 'change' }],
        platform: [{ required: true, message: '请选择平台', trigger: 'change' }],
        tester: [{ 
          required: true, 
          message: '请输入测试人员', 
          trigger: 'change',
          type: 'array',
          min: 1 
        }],
        updater: [{ 
          required: true, 
          message: '请输入更新人', 
          trigger: 'change',
          type: 'array',
          min: 1 
        }]
      },
      countryOptions: [
        { value: 'US', label: '美国' },
        { value: 'BR', label: '巴西' },
        { value: 'MX', label: '墨西哥' },
        { value: 'PE', label: '秘鲁' },
        { value: 'CL', label: '智利' },
        { value: 'AU', label: '澳大利亚' }
      ],
      typeOptions: [
        { value: '新功能', label: '新功能' },
        { value: '新游戏', label: '新游戏' },
        { value: 'bug修复', label: 'bug修复' },
        { value: '功能优化', label: '功能优化' }
      ],
      platformOptions: [
        { value: '前端', label: '前端' },
        { value: '后端', label: '后端' },
        { value: '前后端', label: '前后端' },
        { value: '数据库', label: '数据库' }
      ],
      is_review_options: [
        { value: 1, label: '是' },
        { value: 0, label: '否' }
      ]
    }
  },
  methods: {
    async fetchRecords() {
      try {
        const response = await api.post('/api.php?table=upgrade_record&action=list', this.searchParams )
        this.tableData = response.data.data || []
      } catch (error) {
        this.$message.error('获取数据失败')
      }
    },
    openDialog(type, row) {
      this.dialogType = type
      if (type === 'edit') {
        this.formData = { 
  ...row,
  tester: row.tester ? row.tester.split('、') : [],
  updater: row.updater ? row.updater.split('、') : []
}
      } else {
        this.formData = {
          country: '',
          content: '',
          type: '',
          platform: '',
          tester: '',
          remark: ''
        }
      }
      this.dialogVisible = true
    },
    async submitForm() {
      this.$refs.formRef.validate(async valid => {
        if (valid) {
          try {
            const method = this.dialogType === 'create' ? 'post' : 'put'
            const url = this.dialogType === 'create' 
              ? '/api.php?table=upgrade_record&action=create'
              : `/api.php?table=upgrade_record&action=update&id=${this.formData.id}`
            
            const submitData = {
          ...this.formData,
          tester: this.formData.tester.join('、'),
          updater: this.formData.updater.join('、'),
          update_time: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };
        await api[method](url, submitData)
            this.$message.success('操作成功')
            this.dialogVisible = false
            this.fetchRecords()
          } catch (error) {
            this.$message.error('操作失败')
          }
        }
      })
    },
    async handleDelete(row) {
      try {
        await api.delete(`/api.php?table=upgrade_record&action=delete&id=${row.id}`)
        this.$message.success('删除成功')
        this.fetchRecords()
      } catch (error) {
        this.$message.error('删除失败')
      }
    },
    copyYesterdayContent() {
      // 复制昨日内容逻辑
    },

    async fetchUsers() {
      try {
        const response = await api.get('/api.php?table=user');
        const userList = Array.isArray(response.data.data) ? response.data.data : [];
        for (let index = 0; index < userList.length; index++) {
          const element = userList[index];
          if (element.position === '测试') {
            this.testers.push(element);   
          }else{
            this.develops.push(element);
          }
        }
        // this.develops = userList.filter(user => user.position === '开发');
        // this.testers = userList.filter(user => user.position === '测试');
      } catch (error) {
        console.error('获取用户列表失败:', error);
        this.develops = [];
        this.testers = [];
      }
    },
    formatCountry(row) {
      const found = this.countryOptions.find(opt => opt.value === row.country);
      return found ? found.label : row.country;
    },
    formatReview(row) {
      const found = this.is_review_options.find(opt => opt.value === row.is_review);
      return found ? found.label : row.is_review;
    },
    review(row) {
      this.$refs.fupanDialog.open(row)
    },
  },
  mounted() {
    this.fetchRecords()
    this.fetchUsers();
  }
}
</script>

<style scoped>
.search-area {
  display: flex;
  flex-wrap: nowrap;
  gap: 10px;
  align-items: center;
  margin-bottom: 20px;
}

.el-dialog {
  width: 600px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.el-form {
  padding: 24px 32px;
}

.el-form-item {
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.el-input__inner {
  border-radius: 6px;
  border: 1px solid #dcdfe6;
  padding: 12px 15px;
  transition: all 0.3s;
}

.el-input__inner:focus {
  border-color: #409eff;
  box-shadow: 0 0 0 2px rgba(64, 158, 255, 0.2);
}

.el-textarea__inner {
  flex: 1;
}
.el-form-item__label {
  min-width: 200px;
  width: 200px;
  background-color: #f5f7fa;
  padding: 0 16px;
  margin-right: 16px;
  border-radius: 4px;
  justify-content: flex-start;
}

.el-select,
.el-input,
.el-textarea {
  width: 100%;
  flex: 2;
  min-width: 300px;
}

.el-select .el-input__inner {
  padding: 12px 15px;
}

.el-form-item {
  display: flex;
  align-items: flex-start;
  flex: 1;
}
</style>
