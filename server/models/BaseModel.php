<?php
require_once __DIR__ . '/../config.php';

abstract class BaseModel {
    protected $db;
    protected $table;
    protected $fields = [];

    public function __construct() {
        global $db_host, $db_name, $db_user, $db_pass;
        //echo("mysql:host={$db_host};dbname={$db_name} ". $db_user."  ".$db_pass);
        $this->db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $query = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->returnResult($query);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $query =  $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $this->returnResult($query);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $query =  $stmt->execute([$id]);
    
        return $this->returnResult($query);
    }

    public function list($data) {
      return $this->returnResult([]);
    }


    protected function executeQuery($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function returnResult($data) {
        $ret = [];
        $ret["data"]=$data;
        $ret["code"] = 200;
        return $ret;
    }
}