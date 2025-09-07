# 项目管理系统 - 前端

## 项目概述
基于Vue3+Vite构建的前端管理系统，包含用户管理、记录审查、记录升级等功能模块，采用Element Plus组件库实现界面交互，集成Tiptap富文本编辑器实现内容编辑功能。

## 功能模块
- 用户管理：用户权限配置与账户管理
- 记录审查：历史记录查看与内容验证
- 记录升级：技术方案修订与版本管理

## 技术栈
- 框架：Vue 3 + Vite
- UI组件：Element Plus
- 富文本编辑：@tiptap系列包
- 路由管理：Vue Router 4
- HTTP请求：axios

## 环境要求
- Node.js 18+
- npm 9+

## 安装运行
```bash
npm install
npm run dev
```

## 项目结构
```
src/
├── api/       # 接口模块
├── assets/    # 静态资源
├── components/# 公共组件
├── router/    # 路由配置
├── views/     # 页面视图
│   ├── UserManagement.vue
│   ├── ReviewRecord.vue
│   └── UpgradeRecord.vue
└── main.js    # 入口文件
```

## 开发命令
- `npm run dev`   启动开发服务器
- `npm run build` 生产环境构建
- `npm run preview` 预览生产包

## 依赖说明
核心依赖：
- `@tiptap`系列：富文本编辑器核心及扩展
- `element-plus`: UI组件库
- `vue-router`: 路由管理
- `axios`: HTTP请求库
