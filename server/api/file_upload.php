<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/ReviewRecordModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['error' => '未上传文件']);
        exit;
    }

    $file = $_FILES['file'];
    
    // 验证文件类型和大小
    if (!in_array($file['type'], ALLOWED_TYPES)) {
        http_response_code(415);
        echo json_encode(['error' => '不支持的文件类型']);
        exit;
    }

    if ($file['size'] > MAX_SIZE) {
        http_response_code(413);
        echo json_encode(['error' => '文件超过2MB限制']);
        exit;
    }

    // 生成安全文件名
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid('img_', true) . '.' . $file_ext;
    $target_path = UPLOAD_DIR . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        echo json_encode([
            'url' => '/uploads/' . $new_filename,
            'filename' => $new_filename
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => '文件保存失败']);
    }
}