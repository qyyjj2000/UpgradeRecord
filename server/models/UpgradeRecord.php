<?php
require_once 'BaseModel.php';

class UpgradeRecord extends BaseModel {
    protected $table = 'upgrade_record';
    protected $fields = ['country', 'content', 'update_time', 'updater', 'tester', 'type', 'platform', 'review_conclusion', 'remark'];

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (country, content, update_time, updater, tester, type, platform, review_conclusion, remark) VALUES (?, ?, ?, ?,?, ?, ?, ?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['country'],
            $data['content'],
            $data['update_time'],
            $data['updater'],
            $data['tester'],
            $data['type'],
            $data['platform'],
            $data['review_conclusion'],
            $data['remark']
        ]);
        $obj = $this->db->lastInsertId();

        return $this->returnResult($obj);

    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET country=?, content=?, update_time=?, updater=? , tester=? , type=? , platform=? , review_conclusion=? , remark=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $obj = $stmt->execute([
            $data['country'],
            $data['content'],
            $data['update_time'],
            $data['updater'],
            $data['tester'],
            $data['type'],
            $data['platform'],
            $data['review_conclusion'],
            $data['remark'],
            $id
        ]);

        return $this->returnResult($obj);

    }
}