<?php
    include "../constants.php";
    session_start();
?>
<nav>
    <ul class="nav-list">
        <li class="active padding-s rounded-s"><a href="<?php echo PROJECT_URL; ?>">Home</a></li>
        <li><a href="<?php echo PROJECT_URL; ?>pages/main/listview.php">News</a></li>
        <?php
            if ($_SESSION["role"] && strtoupper($_SESSION["role"]) == "USER"){
                echo '<li><a href="'. PROJECT_URL .'pages/user/favorites.php">Favorites</a></li>';
            } 
            if ($_SESSION["user_id"]){
                echo '<li><a href="'. PROJECT_URL .'pages/authentication/logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="'. PROJECT_URL .'pages/authentication/login.php">Login</a></li>';
            }
        ?>
    </ul>
    <div class="nav-list">
        <?php
            if ($username = $_SESSION["username"]){
                echo '<h4 class="greeting">Hi, '. $username .'</h4>';
            }
        ?>
        <img src="<?php echo PROJECT_URL; ?>/assets/svg/search.svg" alt="Search icon" />
    </div>
</nav>