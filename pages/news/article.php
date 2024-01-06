<!DOCTYPE html>
<html lang="en">
  <?php
    include "../../constants.php";
    include "../../components/head.php";
  ?>
  <body>
    <!-- navigation -->
    <div class="container">
      <?php
        include "../../components/navbar.php";
      ?>
      <main id="article-container" class="container">
        <div class="center-children">
          <h2 id="article-title"></h2>
          <pre id="article-author"></pre>
          <img id="article-image" class="details-article-image" />
          <pre
            style="width: 100%; white-space: pre-wrap"
            id="article-content"
          ></pre>
        </div>
      </main>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>

    <script src="articles.js"></script>
  </body>
</html>
