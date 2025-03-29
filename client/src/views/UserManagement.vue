<template>
  <div>
    <h1>用户管理</h1>
    <el-button type="primary" @click="showAddDialog">添加用户</el-button>
    <el-table :data="userList" style="width: 100%">
      <el-table-column prop="id" label="ID" width="180"></el-table-column>
      <el-table-column prop="username" label="用户名" width="180"></el-table-column>
      <el-table-column prop="position" label="职位"></el-table-column>
      <el-table-column label="操作">
        <template #default="scope">
          <el-button size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button size="small" type="danger" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

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

        this.userList = Array.isArray(response.data.data) ? response.data : [];
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