<!DOCTYPE html>
<html lang="en">
<?php

$title = "| Edit About Us";
include "../../constants.php";
include "../../database/connection.php";
include "../../components/head.php";
include "../../meta/AboutUsManager.php";

session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")) {
    header("Location: " . PROJECT_URL);
    die();
}

$aboutus_obj = new AboutUsManager($db);

$alert = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aboutus_obj->updateData();
    $alert = "About us edited succesfully";
}

?>

<body>
    <div class="container">
        <?php
            include "../../components/adminnavbar.php";
        ?>
        <div style="display: none;" class="alert alert-primary margin-ys">
            <?php echo $alert ?>
        </div>
        <main class="form-layout margin-ys min-height-l">
            <form id="form" class="form" method="POST">
                <h1>Edit About Us</h1>
                <label>
                    New Content:
                    <textarea name="content" rows="8" cols="50"><?php echo $aboutus_obj->getData(); ?></textarea>
                </label>
                <button>Submit</button>
            </form>
            <div>
                <img style="margin-left: -175px;" src="<?php echo PROJECT_URL ?>/assets/teamwork.png" alt="Teamwork image">
            </div>
        </main>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>

</body>
<script>

    let alert = document.querySelector(".alert");

    if (alert.innerHTML.trim() == "") {
        alert.classList.remove("show");
    } else {
        alert.classList.add("show");
    }

</script>
</html>
