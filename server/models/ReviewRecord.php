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
        $sql = "UPDATE {$this->table} SET country=?, record_id=?, review_content=?, review_time=? ,reviewer = ? , conclusion= ? , screenshot_url = ? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $obj = $stmt->execute([
            $data['country'],
            $data['record_id'],
            $data['review_content'],
            $data['review_time'],
            $data['reviewer'],
            $data['conclusion'],
            $data['screenshot_url'],
            $id
        ]);
        return $this->returnResult($obj);

    }

    public function list($params) {
        $conditions = [];
        $bindings = [];

        if (!empty($params['record_id'])) {
            $conditions[] = 'record_id = ?';
            $bindings[] = $params['record_id'];
        }

        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "SELECT * FROM {$this->table} $where";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->returnResult($result);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE record_id = ?");
        $stmt->execute([$id]);
        $query = $stmt->fetch(PDO::FETCH_ASSOC);

        if($query == false ){
            $query = [];
            $query['id'] = 0;
        }
        return $this->returnResult($query);
    }

}