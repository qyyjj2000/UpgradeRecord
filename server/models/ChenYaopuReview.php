<?php
require_once 'BaseModel.php';

class ChenYaopuReview extends BaseModel {
    protected $table = 'chen_yaopu_review';
    protected $fields = ['date', 'purpose', 'initiator', 'participants', 'conclusion', 'screenshot_url'];

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (date, purpose, initiator, participants,conclusion,screenshot_url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['date'],
            $data['purpose'],
            $data['initiator'],
            $data['participants'],
            $data['conclusion'],
            $data['screenshot_url']
        ]);
        $obj = $this->db->lastInsertId();
        return $this->returnResult($obj);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET date=?, purpose=?, initiator=?, participants=? , conclusion=?, screenshot_url=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $obj =  $stmt->execute([
            $data['date'],
            $data['purpose'],
            $data['initiator'],
            $data['participants'],
            $data['conclusion'],
            $data['screenshot_url'],
            $id
        ]);
        return $this->returnResult($obj);


    }

    public function list($data) {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        $conditions = [];

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $conditions[] = "date BETWEEN ? AND ?";
            $params[] = $data['start_date'];
            $params[] = $data['end_date'];
        } else if (!empty($data['start_date'])) {
            $conditions[] = "date >= ?";
            $params[] = $data['start_date'];
        } else if (!empty($data['end_date'])) {
            $conditions[] = "date <= ?";
            $params[] = $data['end_date'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->returnResult($result);
    }
}