<?php
require __DIR__.'/config.php';
require __DIR__.'/models/BaseModel.php';
require __DIR__.'/models/UpgradeRecord.php';
require __DIR__.'/models/User.php';
require __DIR__.'/models/ReviewRecord.php';
require __DIR__.'/models/ChenYaopuReview.php';

// 处理跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    $table = $_GET['table'] ?? '';
    $action = $_GET['action'] ?? 'getAll';
    $id = $_GET['id'] ?? null;

    $model = match($table) {
        'upgrade_record' => new UpgradeRecord(),
        'user' => new User(),
        'review_record' => new ReviewRecord(),
        'chen_yaopu_review' => new ChenYaopuReview(),
        default => throw new Exception('Invalid table parameter')
    };

    $data = json_decode(file_get_contents('php://input'), true);

    switch ($action) {
        case 'create':
            echo json_encode($model->create($data));
            break;
        case 'update':
            echo json_encode($model->update($id, $data));
            break;
        case 'get':
            echo json_encode($model->getById($id));
            break;
        case 'delete':
            echo json_encode($model->delete($id));
            break;
        default:
            echo json_encode($model->getAll());
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}