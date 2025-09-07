<?php
require __DIR__.'/config.php';

// 处理跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


//curl -X POST -F "record_id=123" -F "image=@test.jpg" http://localhost:8000/upload.php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    // 校验必要参数
    if (!isset($_POST['record_id'])) {
        throw new Exception('缺少record_id参数');
    }

    // 校验文件上传
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('文件上传失败');
    }

    $file = $_FILES['image'];
    
    // 校验文件类型和大小
    if (!in_array($file['type'], ALLOWED_TYPES)) {
        throw new Exception('不允许的文件类型');
    }
    
    if ($file['size'] > MAX_SIZE) {
        throw new Exception('文件大小超过限制');
    }

    // 生成带时间戳的文件名
    $record_id = $_POST['record_id'];
    $timestamp = time();
    $filename = sprintf('%s_%d.jpg', $record_id, $timestamp);
    $target_path = UPLOAD_DIR . $filename;

    // 移动文件到上传目录
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        throw new Exception('文件保存失败');
    }

    // 返回相对路径
    echo json_encode([
        'status' => 'success',
        'message' => '上传成功',
        'data' => ['path' => '/uploads/' . $filename]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}