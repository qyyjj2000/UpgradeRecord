<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../api/db_connect.php';

class UserModel {
    public function create($data) {
        $sql = "INSERT INTO user (username, position) VALUES (?, ?)";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param("ss", 
            $data['username'],
            $data['position']
        );
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $GLOBALS['conn']->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM user WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data) {
        $allowedFields = ['username', 'position'];
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

        $sql = "UPDATE user SET " . implode(', ', $updates) . " WHERE id=?";
        $params[] = $id;
        $types .= 'i';

        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM user WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}