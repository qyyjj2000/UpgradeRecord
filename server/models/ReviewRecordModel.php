<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../api/db_connect.php';

class ReviewRecordModel {
    public function create($data) {
        // 必填字段校验
        $requiredFields = ['country', 'record_id', 'review_content', 'review_time', 'reviewer', 'conclusion'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return false;
            }
        }

        // 检查外键record_id是否存在
        $checkStmt = $GLOBALS['conn']->prepare("SELECT id FROM upgrade_record WHERE id=?");
        $checkStmt->bind_param("i", $data['record_id']);
        $checkStmt->execute();
        if (!$checkStmt->get_result()->num_rows) {
            return false;
        }

        // 动态构建字段
        $fields = ['country', 'record_id', 'review_content', 'review_time', 'reviewer', 'conclusion'];
        $placeholders = ['?', '?', '?', '?', '?', '?'];
        $types = 'sissss'; // s=country, i=record_id, s=review_content, s=review_time, s=reviewer, s=conclusion
        $values = [
            $data['country'],
            $data['record_id'],
            $data['review_content'],
            $data['review_time'],
            $data['reviewer'],
            $data['conclusion']
        ];

        // 处理可选字段
        if (!empty($data['screenshot_url'])) {
            $fields[] = 'screenshot_url';
            $placeholders[] = '?';
            $types .= 's';
            $values[] = $data['screenshot_url'];
        }

        $sql = "INSERT INTO review_record (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public function getByRecordId($record_id) {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM review_record WHERE record_id=?");
        $stmt->bind_param("i", $record_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function update($id, $data) {
        $allowedFields = ['country', 'review_content', 'review_time', 'reviewer', 'conclusion', 'screenshot_url'];
        $updates = [];
        $params = [];
        $types = '';

        // 检查外键record_id是否存在
        if (isset($data['record_id'])) {
            $checkStmt = $GLOBALS['conn']->prepare("SELECT id FROM upgrade_record WHERE id=?");
            $checkStmt->bind_param("i", $data['record_id']);
            $checkStmt->execute();
            if (!$checkStmt->get_result()->num_rows) {
                return false;
            }
        }

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

        $sql = "UPDATE review_record SET " . implode(', ', $updates) . " WHERE id=?";
        $params[] = $id;
        $types .= 'i';

        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM review_record WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM review_record");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}