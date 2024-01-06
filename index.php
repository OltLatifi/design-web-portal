<!DOCTYPE html>
<html lang="en">
  <?php
  $title = "| Home";
  include "constants.php";
  include "components/head.php";
  ?>
  <body>
    <!-- navigation -->
    <div class="container">
      <?php
        include "components/navbar.php";
        include "database/connection.php";
      ?>
      <!-- main content -->
      <main class="margin-ys">
        <h1>Hot Topics</h1>
        <a id="main-topic" class="main-topic">
          <div id="hot-topics" class="div-image image-content">
            <div class="main-topic-data">
              <h2 id="hot-article-title"></h2>
              <div class="metadata">
                <span>2 Hours Ago</span>
                <span>CNN</span>
              </div>
            </div>
          </div>
          <p id="hot-article-content"></p>
        </a>
      </main>
      <!-- list section -->
      <section class="margin-ys">
        <h1>Latest News</h1>
        <div class="list-section" id="articles-list"></div>
      </section>
    </div>

    <!-- footer -->
    <?php
      include "components/footer.php";
    ?>
    <script src="index.js"></script>
  </body>
</html>
