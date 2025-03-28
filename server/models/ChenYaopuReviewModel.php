<?php

class ChenYaopuReviewModel {
    // 移除私有属性$db
    public function __construct() {
        // 构造函数内容已保留但不再需要属性存储连接
    }

    public function getById($id) {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM chen_yaopu_review WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        // 必填字段校验
        $requiredFields = ['purpose', 'initiator', 'participants', 'conclusion'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("$field 字段不能为空");
            }
        }

        // 字段白名单过滤
        $allowedFields = ['purpose', 'initiator', 'participants', 'conclusion'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        // 预处理SQL
        $columns = implode(', ', array_keys($filteredData));
        $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));
        
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO chen_yaopu_review ($columns) VALUES ($placeholders)");
        
        // 绑定参数
        $types = str_repeat('s', count($filteredData));
        $values = array_values($filteredData);
        $stmt->bind_param($types, ...$values);

        if (!$stmt->execute()) {
            throw new Exception("创建记录失败: " . $stmt->error);
        }

        return $GLOBALS['conn']->insert_id;
    }

    public function delete($id) {
        // 存在性检查
        $checkStmt = $GLOBALS['conn']->prepare("SELECT id FROM chen_yaopu_review WHERE id = ?");
        $checkStmt->bind_param('i', $id);
        $checkStmt->execute();
        if (!$checkStmt->get_result()->num_rows) {
            throw new Exception("指定记录不存在");
        }

        $stmt = $GLOBALS['conn']->prepare("DELETE FROM chen_yaopu_review WHERE id = ?");
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new Exception("删除记录失败: " . $stmt->error);
        }

        return $stmt->affected_rows;
    }

    public function getAll() {
        $stmt = $GLOBALS['conn']->query("SELECT * FROM chen_yaopu_review");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        // 必填字段校验
        $requiredFields = ['purpose', 'initiator', 'participants', 'conclusion'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("$field 字段不能为空");
            }
        }

        // 字段白名单过滤
        $allowedFields = ['purpose', 'initiator', 'participants', 'conclusion'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        // 构建动态SET子句
        $setClauses = [];
        $params = [];
        foreach ($filteredData as $key => $value) {
            $setClauses[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $id;

        $sql = "UPDATE chen_yaopu_review SET " . implode(', ', $setClauses) . " WHERE id = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);

        // 绑定参数（所有字段值+id）
        $types = str_repeat('s', count($filteredData)) . 'i';
        $stmt->bind_param($types, ...$params);

        if (!$stmt->execute()) {
            throw new Exception("更新记录失败: " . $stmt->error);
        }

        return $stmt->affected_rows;
    }
}