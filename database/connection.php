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

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt) {
            if (!empty($params)) {
                $types = $params[0];
                $values = array_slice($params, 1);
                $stmt->bind_param($types, ...$values);
            }
    
            $executeResult = $stmt->execute();
    
            if (!$executeResult) {
                echo "Query execution failed: " . $stmt->error;
                return false;
            }
    
            $result = $stmt->get_result();
    
            if ($result === false) {
                echo "Failed to get result: " . $stmt->error;
                return false;
            }
    
            $data = $result->fetch_all(MYSQLI_ASSOC);
    
            $stmt->close();
    
            return $data;
        } else {
            echo "Prepare statement failed: " . $this->conn->error;
            return false;
        }
    }
    
    

    public function close() {
        $this->conn->close();
    }
}

$db = new Database("portal");

?>
