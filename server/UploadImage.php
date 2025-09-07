<?php
// 处理跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();

// 模拟登录状态（测试时临时启用）
// $_SESSION['user_id'] = 1;

// if (empty($_SESSION['user_id'])) {
//   die(json_encode(['status' => 'error', 'message' => '未登录', 'code' => 401]));
// }

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

// 参数校验增强版
if (empty($data['image']) || !isset($data['record_id']) || !is_numeric($data['record_id'])) {
  die(json_encode([
    'status' => 'error', 
    'message' => '参数错误',
    'received_data' => $data
  ]));
}

// $userId = $_SESSION['user_id'];
$recordId = (int)$data['record_id'];
$base64String = $data['image'];

try {
  // $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'password');
  // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // 验证记录所有权
  // $stmt = $pdo->prepare("SELECT id FROM records WHERE id = ? AND user_id = ?");
  // $stmt->execute([$recordId, $userId]);
  // if ($stmt->rowCount() === 0) {
  //   throw new Exception('记录不存在或无权操作');
  // }

  // 处理图片数据
  if (!preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
    throw new Exception('非法图片格式');
  }

  $imageType = strtolower($matches[1]);
  $allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];
  if (!in_array($imageType, $allowedTypes)) {
    throw new Exception('不支持的文件类型');
  }

  $base64Data = substr($base64String, strpos($base64String, ',') + 1);
  $imageBinary = base64_decode($base64Data);
  if ($imageBinary === false) {
    throw new Exception('Base64解码失败');
  }

  // 创建上传目录
  $uploadDir = __DIR__ . '/upload/';
  if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  $fileName = "rec_{$recordId}_" . uniqid() . ".{$imageType}";
  $filePath = $uploadDir . $fileName;

  // 写入文件
  if (file_put_contents($filePath, $imageBinary) === false) {
    throw new Exception('文件保存失败: ' . error_get_last()['message']);
  }

  // 更新数据库
  // $stmt = $pdo->prepare("UPDATE records SET image_path = ? WHERE id = ?");
  // $stmt->execute([$filePath, $recordId]);

  echo json_encode([
    'status' => 'success',
    'path' => $filePath,
    'url' => "http://10.10.10.95/Record/server/upload/{$fileName}"
  ]);

} catch (PDOException $e) {
  die(json_encode([
    'status' => 'error',
    'message' => '数据库错误',
    'error' => $e->getMessage()
  ]));
} catch (Exception $e) {
  die(json_encode([
    'status' => 'error',
    'message' => $e->getMessage(),
    'error_code' => $e->getCode()
  ]));
}
?>