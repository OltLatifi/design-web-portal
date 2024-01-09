<?php
    include "../../constants.php";
    session_start();

    if(!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "STAFF")){
        header("Location: " . PROJECT_URL);
        die();
    }
?>
<h1>staff dashboard</h1>