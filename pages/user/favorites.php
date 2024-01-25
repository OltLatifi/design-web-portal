


<!DOCTYPE html>
<html lang="en">
<?php
    $title = "| Favourites";
    include "../../constants.php";
    include "../../database/connection.php";
    include "../../components/head.php";
    include "../../meta/ArticleListManager.php";

    session_start();

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseURL = "{$protocol}://{$host}"; 

    if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "USER")) {
        header("Location: " . PROJECT_URL);
        die();
    }

    $articleManager = new ArticleListManager($db);
    $articleList = $articleManager->getFavouriteArticles($_SESSION["user_id"])

?>

<body>
    <div class="container">
        <!-- navigation -->
        <?php include "../../components/navbar.php"; ?>

        <section class="margin-ys min-height-m">
            <h1>Your Favorite Articles</h1>
            <div class="list-section" id="favorites-list">
                <?php
                if ($articleList) {
                    foreach ($articleList as $article) {
                        $articleId = $article['id'];
                        $published_at = date("F jS, Y", strtotime($article['published_at']));
                        echo "
                        <a class='single-article'  href='". PROJECT_URL . "pages/main/article.php?id=" . $articleId."'>
                            <img class='index-list-article' src='". $baseURL .$article['image']."' alt='Article Image". $article['id']."'>
                            <h3>".$article['title']."</h3>
                            <div class='metadata'>
                            <span>".$published_at."</span>
                            <span>". $article['first_name']. " " .$article['last_name'] ."</span>
                            </div>
                        </a>";
                    }
                } else {
                    echo "<p>You don't have any favorite articles</p>";
                }
                ?>
            </div>
        </section>
    </div>

    <!-- footer -->
    <?php include "../../components/footer.php"; ?>
</body>

</html>