<!DOCTYPE html>
<html lang="en">
  <?php
    $title = "| News";
    include "../../constants.php";
    include "../../components/head.php";
  ?>
  <body>
    <div class="container">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <!-- slider -->
      <div id="slider" class="margin-ys">
        <button onclick="goPrevious()"><</button>
        <button onclick="goNext()">></button>
      </div>

      <!-- list section -->
      <section class="margin-ys">
        <h1>Latest News</h1>
        <div class="list-section" id="articles-list"></div>
      </section>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>

    <script src="./slider.js" async defer />
  </body>
</html>
