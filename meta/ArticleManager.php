<?php

class ArticleManager {
    public $db;
    public $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = $_SESSION["user_id"];
    }

    public function list($status) {
        $sql = "SELECT * FROM article WHERE author_id = ?";
        $params = ['s', $this->user];
        if ($status !== null){
            $sql .= " AND status = ?";
            $params = ['ss', $this->user, $status];
        }

        return $this->db->query($sql, $params);
    }

    public function changeStatus($id, $status) {
        if($status == 1){
            $date = date('Y-m-d H:i:s');
        } else {
            $date = "0000-00-00 00:00:00";
        }

        $sql = "UPDATE article SET status = ?, published_at = ?  WHERE author_id = ? AND id = ?";
        $params = ['isss', $status, $date, $this->user, $id];
        return $this->db->query($sql, $params);
    }
}

?>