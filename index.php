<!DOCTYPE html>
<html lang="en">
  <?php
  $title = "| Home";
  include "constants.php";
  include "components/head.php";
  include "database/connection.php";
  include "meta/ArticleListManager.php";
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];
  $baseURL = "{$protocol}://{$host}";
  
  $articleManager = new ArticleListManager($db);

  $publishedArticles = $articleManager->getPublishedArticles();

  ?>
  <body>
    <!-- navigation -->
    <div class="container">
      <?php
        include "components/navbar.php";
        $mainArticle = $publishedArticles[0];
        $ma_published_at = date("F jS, Y", strtotime($mainArticle['published_at']));
      ?>
      <!-- main content -->
      <main class="margin-ys">
        <h1>Hot Topics</h1>
        <a id="main-topic" class="main-topic">
          <div id="hot-topics" class="div-image image-content" style=
        "<?php

          echo "background: url($baseURL" . "{$mainArticle['image']}), linear-gradient(180deg, transparent, black);"
        ?>background-size: cover !important;">
            <div class="main-topic-data">
              <h2 id="hot-article-title"><?php echo $mainArticle["title"] ?></h2>
              <div class="metadata">
                <span><?php echo $ma_published_at; ?></span>
                <span><?php echo $mainArticle['first_name']. " " .$mainArticle['last_name'] ?></span>
              </div>
            </div>
          </div>
          <p id="hot-article-content"><?php echo substr($mainArticle["content"], 0, 300) ?></p>
        </a>
      </main>
      <!-- list section -->
      <section class="margin-ys">
        <h1>Latest News</h1>
        <div class="list-section" id="articles-list">
          <?php
            $index = 0;
            if ($publishedArticles !== false) {
              foreach ($publishedArticles as $article) {
                if ($index++ == 0) continue;
                $published_at = date("F jS, Y", strtotime($article['published_at']));
                echo "
                <a class='single-article'>
                  <img class='index-list-article' src='".$baseURL .$article['image']."' alt='Article Image". $article['id']."'>
                  <h3>".$article['title']."</h3>
                  <div class='metadata'>
                  <span>".$published_at."</span>
                  <span>". $article['first_name']. " " .$article['last_name'] ."</span>
                  </div>
                </a>";
              }
            } else {
              echo "Error retrieving articles.";
            }
          ?>
        </div>
      </section>
    </div>

    <!-- footer -->
    <?php
      include "components/footer.php";
    ?>
  </body>
</html>
