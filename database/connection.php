<?php

class Database {
    private $conn;

    public function __construct($dbname) {
        $servername = "localhost";
        $username = "root";
        $password = "";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function query($sql) {
        $prepared_sql = $this->conn->prepare($sql);
        return $this->conn->query($sql);
    }

    public function close() {
        $this->conn->close();
    }
}

$db = new Database("portal");

?>
