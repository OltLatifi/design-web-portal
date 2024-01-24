<!DOCTYPE html>
<html lang="en">
  <?php
    $title = "| About us";
    include "../../constants.php";
    include "../../database/connection.php";
    include "../../components/head.php";
    include "../../meta/AboutUsManager.php";
    $aboutus_obj = new AboutUsManager($db);

  ?>

  <body>
    <main class="container min-height-m">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <div>
        <h1 class="margin-ys">Our Story</h1>
        <p class="about-us-paragraphs">
          <?php echo $aboutus_obj->getData() ?>
        </p>
      </div>
</main>
    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
</html>
