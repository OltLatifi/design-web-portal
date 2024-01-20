<?php

class PersonnelMannager {
    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function list() {
        $sql = "SELECT * FROM user";
        return $this->db->query($sql);
    }
}

?>