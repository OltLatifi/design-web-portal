<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION["role"] && strtoupper($_SESSION["role"]) == "USER")) {
    include "../../database/connection.php";

    $userId = $_SESSION["role"];
    $articleId = $_POST['articleId'];

    $addToFavoritesSQL = "INSERT INTO favorites (user_id, article_id) VALUES (?, ?)";
    $params = [$userId, $articleId];
    $result = $db->query($addToFavoritesSQL, $params);

    $db->close();
    if ($result) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } 
}
?>
