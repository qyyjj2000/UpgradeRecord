<?php
require_once 'BaseModel.php';

class User extends BaseModel {
    protected $table = 'user';
    protected $fields = ['username', 'position'];

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, position) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['username'],
            $data['position']
        ]);
        $query = $this->db->lastInsertId();
        return $this->returnResult($query);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET username=?, position=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $query = $stmt->execute([
            $data['username'],
            $data['position'],
            $id
        ]);

        return $this->returnResult($query);

    }

    public function getAll() {
        // echo ($this->table);
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $query =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->returnResult($query);

    }
}