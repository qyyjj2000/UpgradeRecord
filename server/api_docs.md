# API接口文档

## 基础信息
- 入口文件：`api.php`
- 支持方法：GET/POST/PUT/DELETE
- 返回格式：JSON
- 跨域支持：已启用

## 通用参数
| 参数名 | 必填 | 说明 |
|--------|------|-----|
| table  | 是  | 操作的数据表（user/upgrade_record/review_record等） |
| action | 否  | 操作类型（默认getAll） |
| id     | 否  | 记录ID（用于get/update/delete操作） |

## 接口示例

### 获取所有用户
```http
GET /api.php?table=user
```

### 获取单个用户
```http
GET /api.php?table=user&action=get&id=1
```

### 创建记录（POST JSON）
```http
POST /api.php?table=upgrade_record&action=create
Content-Type: application/json

{
  "name": "系统升级",
  "version": "2.0.0"
}
```

### 更新记录
```http
PUT /api.php?table=review_record&action=update&id=5
Content-Type: application/json

{
  "status": "approved"
}
```

### 删除记录
```http
DELETE /api.php?table=chen_yaopu_review&action=delete&id=3
```

## 响应格式
成功响应：
```json
{
  "status": "success",
  "data": [...]
}
```

错误响应：
```json
{
  "status": "error",
  "message": "错误描述"
}
```