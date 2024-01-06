<?php
    include "../../constants.php";
    session_start();

    if(!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")){
        header("Location: " . $PROJECT_URL);
        die();
    }
?>
<h1>test</h1>