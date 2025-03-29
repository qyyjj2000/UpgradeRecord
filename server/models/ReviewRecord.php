<?php
require_once 'BaseModel.php';

class ReviewRecord extends BaseModel {
    protected $table = 'review_record';
    protected $fields = ['country', 'record_id', 'review_content', 'review_time','reviewer','conclusion','screenshot_url'];

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (country, record_id, review_content, review_time,reviewer,conclusion,screenshot_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['country'],
            $data['record_id'],
            $data['review_content'],
            $data['review_time'],
            $data['reviewer'],
            $data['conclusion'],
            $data['screenshot_url']
        ]);
        $obj = $this->db->lastInsertId();

        return $this->returnResult($obj);

    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET applicant=?, review_status=?, review_time=?, reviewer=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $obj = $stmt->execute([
            $data['applicant'],
            $data['review_status'],
            $data['review_time'],
            $data['reviewer'],
            $id
        ]);
        return $this->returnResult($obj);

    }
}