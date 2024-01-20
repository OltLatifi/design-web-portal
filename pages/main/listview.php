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
  
    $publishedArticles = $articleManager->getPublishedArticles();
  ?>
  <body>
    <div class="container">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <!-- slider -->
      <div id="slider" class="margin-ys">
        <?php
          $slides = 2;
          for ($i = 0; $i <= $slides; $i++) {
            $published_at = date("F jS, Y", strtotime($publishedArticles[$i]['published_at']));
            echo "<a href='". PROJECT_URL . "pages/main/article.php?id=" . $publishedArticles[$i]['id'] ."' class='slider-article ". ($i == 0? '': 'hide') ."' id='slide_{$i}'>
              <img src='" . $baseURL . $publishedArticles[$i]["image"] . "' alt='Article image " . $publishedArticles[$i]['id'] . "'>
              <h3>" . $publishedArticles[$i]["title"] . "</h3>
              <div class='metadata'>
                  <span>{$published_at}</span>
                  <span>" . $publishedArticles[$i]['first_name'] . " " . $publishedArticles[$i]['last_name'] . "</span>
              </div>
            </a>";
          }
        ?>
        <button type="button" style="left: 1rem;" onclick="goPrevious()"><</button>
        <button type="button" style="right: 1rem;" onclick="goNext()">></button>
      </div>

      <!-- list section -->
      <section class="margin-ys">
        <h1>Latest News</h1>
        <div class="list-section" id="articles-list">
        <?php
            $index = 0;
            if ($publishedArticles !== false) {
              foreach ($publishedArticles as $article) {
                if ($index++ < $slides) continue;
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
      include "../../components/footer.php";
    ?>

    <script>
      let articles;
      let biggestId = parseInt(<?php echo $slides ?>);

      let slide = 0;
      function clearAll() {
        let slides = document.querySelectorAll(".slider-article");
        slides.forEach((el) => el.classList.add("hide"));
      }

      function goNext() {
        clearAll();
        if (slide < biggestId) {
          slide++;
        } else {
          slide = 0;
        }
        document.getElementById("slide_" + slide).classList.remove("hide");
      }

      function goPrevious() {
        clearAll();
        if (slide > 0) {
          slide--;
        } else {
          slide = biggestId;
        }
        document.getElementById("slide_" + slide).classList.remove("hide");
      }

  </script>
  </body>
</html>
