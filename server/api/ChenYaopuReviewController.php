<?php
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/../models/ChenYaopuReviewModel.php';

header("Content-Type: application/json");

try {
    $model = new ChenYaopuReviewModel();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $records = $model->getAll();
            echo json_encode(['success' => true, 'data' => $records]);
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['user_id']) || empty($input['review_date'])) {
                throw new Exception("必要字段不能为空", 400);
            }
            $result = $model->create($input);
            respondWithResult($result, 201, '记录创建成功');
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['id']) || empty($input['status'])) {
                throw new Exception("ID和状态不能为空", 400);
            }
            $result = $model->update($input['id'], $input);
            respondWithResult($result, 200, '记录更新成功');
            break;

        case 'DELETE':
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['id'])) {
                throw new Exception("ID不能为空", 400);
            }
            $result = $model->delete($input['id']);
            respondWithResult($result, 200, '记录删除成功');
            break;

        default:
            throw new Exception("不支持的请求方法", 405);
    }
} catch (Exception $e) {
    handleException($e);
}

function respondWithResult($result, $successCode, $message) {
    if ($result) {
        http_response_code($successCode);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'id' => $GLOBALS['conn']->insert_id ?? null
        ]);
    } else {
        throw new Exception("操作失败", 500);
    }
}

function handleException($e) {
    http_response_code((int)$e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
}