<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $conn = new PDO(
        'mysql:host=localhost;dbname=Record;charset=utf8mb4',
        'Record',
        'Record123',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => '数据库连接失败']);
    exit;
}

$GLOBALS['conn'] = $conn;
?>