<?php
include "../../database/connection.php";

session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")) {
  header("Location: " . PROJECT_URL);
  die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newContent = $_POST["new_content"];
    $insertContentSQL = "INSERT INTO about_us (content) VALUES (?)";
    $params = ["s", $newContent];
    $result = $db->query($insertContentSQL, $params);

    if ($result) {
        header("Location: " . PROJECT_URL . "/about_us.php");
        die();
    }
}
?>

<div>
    <p><?php echo $aboutUsContent; ?></p>
</div>

<!-- Form for updating the "About Us" content -->
<form method="post">
    <label>
        New Content:
        <textarea name="new_content" rows="4" cols="50"></textarea>
    </label>
    <button type="submit">Update Content</button>
</form>
