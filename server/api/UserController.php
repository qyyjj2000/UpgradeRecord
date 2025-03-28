<?php
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/../models/UserModel.php';

header("Content-Type: application/json");

try {
    $userModel = new UserModel();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $users = $userModel->getAll();
            echo json_encode(['success' => true, 'data' => $users]);
            break;

        case 'POST':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("仅支持POST请求", 405);
            }

            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['username']) || empty($input['position'])) {
                throw new Exception("用户名和职位不能为空", 400);
            }

            $result = $userModel->create([
                'username' => $input['username'],
                'position' => $input['position']
            ]);

            if (!$result) {
                throw new Exception("用户创建失败", 500);
            }
            
            respondWithResult($result, 201, '用户创建成功');
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['id']) || empty($input['position'])) {
                throw new Exception("ID和职位不能为空", 400);
            }
            $result = $userModel->update($input['id'], $input);
            respondWithResult($result, 200, '用户更新成功');
            break;

        case 'DELETE':
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['id'])) {
                throw new Exception("ID不能为空", 400);
            }
            $result = $userModel->delete($input['id']);
            respondWithResult($result, 200, '用户删除成功');
            break;

        default:
            throw new Exception("不支持的请求方法", 405);
    }

} catch (Exception $e) {
    http_response_code((int)$e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
}