<?php
    include "../constants.php";
    session_start();
?>
<nav>
    <ul class="nav-list">
        <li class="active padding-s rounded-s"><a href="<?php echo PROJECT_URL; ?>pages/staff/dashboard.php">Dashboard</a></li>
        <li><a href="<?php echo PROJECT_URL; ?>pages/staff/addarticle.php">Add article</a></li>
        <li><a href="<?php echo PROJECT_URL; ?>pages/staff/drafts.php">Drafts</a></li>
        <li><a href="<?php echo PROJECT_URL; ?>pages/staff/published.php">Published</a></li>
        <li><a href="<?php echo PROJECT_URL; ?>pages/authentication/logout.php">Logout</a></li>

    </ul>
    <div class="nav-list">
        <?php
            if ($username = $_SESSION["username"]){
                echo '<h4 class="greeting">Hi, '. $username .'</h4>';
            }
        ?>
        <a href="<?php echo PROJECT_URL; ?>">View Site</a>
    </div>
</nav>