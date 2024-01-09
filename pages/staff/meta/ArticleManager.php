<?php

class ArticleManager {
    private $db;
    private $user;

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
        $sql = "UPDATE article SET status = ? WHERE author_id = ? AND id = ?";
        $params = ['iss', $status, $this->user, $id];
        return $this->db->query($sql, $params);
    }
}

?>