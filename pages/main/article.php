<!DOCTYPE html>
<html lang="en">
  <?php
    $title = "| News";
    include "../../constants.php";
    include "../../database/connection.php";
    include "../../components/head.php";
    include "../../meta/ArticleListManager.php";

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseURL = "{$protocol}://{$host}";
    
    $articleManager = new ArticleListManager($db);

    $id = $_GET['id'];
  
  ?>
  <body>
    <div class="container">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <?php
        if(isset($_GET['id'])){
            $article = $articleManager->getArticleById($id);
        } else {
            echo "'id' is a required query param";
        }
      ?>

      <!-- article section -->
      <main class="margin-ys">
        <h2 class="article-title"><?php echo $article["title"] ?></h2>
        <p class="article-author">Author: <?php echo $article["first_name"] ?> <?php echo $article["last_name"] ?> • <?php echo date("F jS, Y", strtotime($publishedArticles[$i]['published_at'])) ?></p>
        <img class="article-image" src="<?php echo $baseURL . $article["image"] ?>"/>
        <pre class="article-content margin-ys"><?php echo $article["content"] ?></pre>
      </main>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
</html>
