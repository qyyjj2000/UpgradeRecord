<?php

// 数据库配置
const DB_HOST = 'localhost';
const DB_NAME = 'Record';
const DB_USER = 'Record';
const DB_PASS = 'Record123';

// 文件上传配置
const UPLOAD_DIR = __DIR__ . '/../uploads/';
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
const MAX_SIZE = 2 * 1024 * 1024; // 2MB

// 创建上传目录（如果不存在）
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}