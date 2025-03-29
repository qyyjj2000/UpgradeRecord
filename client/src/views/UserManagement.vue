<template>
  <div>
    <div class="button_add">
      <el-button type="primary" @click="showAddDialog">添加用户</el-button>
    </div>
    <div class="table-container">
      <el-table :data="userList" style="width: 100%" header-align="center" align="center" border>
      <el-table-column prop="id" label="ID" width="180" header-align="center" align="center"></el-table-column>
      <el-table-column prop="username" label="用户名" width="180" header-align="center" align="center"></el-table-column>
      <el-table-column prop="position" label="职位" header-align="center" align="center"></el-table-column>
      <el-table-column label="操作" header-align="center" align="center">
        <template #default="scope">
          <el-button size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button size="small" type="danger" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    </div>

    <el-dialog v-model="dialogVisible" :title="dialogTitle">
      <el-form :model="formData">
        <el-form-item label="用户名">
          <el-input v-model="formData.username" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="职位">
          <el-input v-model="formData.position" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisible = false">取消</el-button>
          <el-button type="primary" @click="submitForm">确认</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<style scoped>
.table-container {
  width: 75%;
  margin: 0 auto;
}

.button_add {
  width: 75%;
  margin: 0 auto;
  margin-top: 5px;
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.el-button--primary {
  margin-left: 0;
  margin-bottom: 15px;
}

h1 + .el-button {
  display: block;
  width: 75%;
  margin: 0 auto 15px auto;
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
  margin-bottom: 24px;
  display: flex;
  align-items: center;
}

.el-form-item__label {
  min-width: 120px;
  width: 120px;
  background-color: #f5f7fa;
  padding: 0 16px;
  margin-right: 16px;
  border-radius: 4px;
}

.el-form-item {
  margin-bottom: 16px;
}

.el-input {
  width: 100%;
}

.el-input__inner {
  border-radius: 6px;
  border: 1px solid #dcdfe6;
  padding: 12px 15px;
  transition: all 0.3s;
  font-size: 14px;
}

.el-input__inner:hover {
  border-color: #c0c4cc;
}

.el-input__inner:focus {
  border-color: #409eff;
  box-shadow: 0 0 0 2px rgba(64, 158, 255, 0.2);
  outline: none;
}

.dialog-footer {
  display: flex;
  justify-content: flex-end;
  padding: 16px 32px;
  border-top: 1px solid #ebeef5;
}

.dialog-footer .el-button {
  margin-left: 12px;
  padding: 10px 20px;
}
</style>

<script>
import api from '../api/index.js'

export default {
  name: 'UserManagement',
  data() {
    return {
      userList: [],
      dialogVisible: false,
      dialogTitle: '',
      formData: {
        username: '',
        position: ''
      },
      currentId: null
    }
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await api.get('/api.php?table=user');
        console.log(response.data);

        this.userList = Array.isArray(response.data.data) ? response.data.data : [];
      } catch (error) {
        console.error('获取用户列表失败:', error);
        this.userList = [];
      }
    },
    showAddDialog() {
      this.dialogTitle = '添加用户';
      this.formData = { username: '', position: '' };
      this.currentId = null;
      this.dialogVisible = true;
    },
    handleEdit(row) {
      this.dialogTitle = '编辑用户';
      this.formData = { username: row.username, position: row.position };
      this.currentId = row.id;
      this.dialogVisible = true;
    },
    async submitForm() {
      try {
        if (this.currentId) {
          // 更新用户
          await api.put(`/api.php?table=user&action=update&id=${this.currentId}`, this.formData);
        } else {
          // 添加用户
          await api.post('/api.php?table=user&action=create', this.formData);
        }
        this.dialogVisible = false;
        this.fetchUsers();
      } catch (error) {
        console.error('操作失败:', error);
      }
    },
    async handleDelete(row) {
      try {
        await api.delete(`/api.php?table=user&action=delete&id=${row.id}`);
        this.fetchUsers();
      } catch (error) {
        console.error('删除失败:', error);
      }
    }
  }
}
</script>