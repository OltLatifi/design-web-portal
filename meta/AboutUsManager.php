<?php

class AboutUsManager {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getData() {
        $sql = "SELECT content FROM about_us WHERE id = 1";
        return $this->db->query($sql)[0]['content'];
    }

    public function updateData() {
        $content = $_POST["content"];

        $sql = "UPDATE about_us SET content = ? WHERE id = 1";
        $params = ["s", $content];
    
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param(...$params);
        $stmt->execute();
    }
}


?>