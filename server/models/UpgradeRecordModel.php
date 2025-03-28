<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../api/db_connect.php';

class UpgradeRecordModel {
    public function create($data) {
        $sql = "INSERT INTO upgrade_record (country, content, update_time, updater, tester, type, platform, review_conclusion, remark) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $GLOBALS['conn']->prepare($sql);
        // 定义ENUM校验规则
        $allowedTypes = ['feature', 'bugfix', 'optimization'];
        $allowedPlatforms = ['web', 'mobile', 'desktop'];
        
        // 校验必填字段
        $requiredFields = ['country', 'content', 'update_time', 'updater'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return false;
            }
        }

        // 校验ENUM字段
        if (isset($data['type']) && !in_array($data['type'], $allowedTypes)) {
            return false;
        }
        if (isset($data['platform']) && !in_array($data['platform'], $allowedPlatforms)) {
            return false;
        }

        // 动态构建字段列表
        $fields = ['country', 'content', 'update_time', 'updater'];
        $placeholders = ['?', '?', '?', '?'];
        $types = 'ssss';
        $values = [
            $data['country'],
            $data['content'],
            $data['update_time'],
            $data['updater']
        ];

        // 处理可选字段
        $optionalFields = [
            'tester' => 's',
            'type' => 's',
            'platform' => 's',
            'review_conclusion' => 's',
            'remark' => 's'
        ];

        foreach ($optionalFields as $field => $type) {
            if (isset($data[$field])) {
                $fields[] = $field;
                $placeholders[] = '?';
                $types .= $type;
                $values[] = $data[$field];
            }
        }

        $sql = "INSERT INTO upgrade_record (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $GLOBALS['conn']->query("SELECT * FROM upgrade_record");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM upgrade_record WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data) {
        $allowedFields = ['country', 'content', 'update_time', 'updater', 'tester', 'type', 'platform', 'review_conclusion', 'remark'];
        $updates = [];
        $params = [];
        $types = '';

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                if (!is_string($data[$field])) {
                    return false;
                }
                $updates[] = "$field=?";
                $params[] = $data[$field];
                $types .= 's';
            }
        }

        if (empty($updates)) {
            return false;
        }

        $sql = "UPDATE upgrade_record SET " . implode(', ', $updates) . " WHERE id=?";
        $params[] = $id;
        $types .= 'i';

        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM upgrade_record WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}