<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "../../database/connection.php";
    include "../../constants.php";

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertUserSQL = "INSERT INTO user (first_name, last_name, email, username, role, password) VALUES (?, ?, ?, ?)";
    $params = [$first_name, $last_name, $email, $username, "USER", $hashedPassword];

    $result = $db->query($insertUserSQL, $params);

    if ($result) {
        header("Location: " . PROJECT_URL);
        die();
    }

    $db->close();
}
?>
