<?php
session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "USER")) {
  header("Location: " . PROJECT_URL);
  die();
}

include "../../database/connection.php";

$user_id = $_SESSION['user_id'];
$favorites_sql = "
    SELECT *
    FROM favorites
    JOIN article ON favorites.article_id = article.id
    WHERE favorites.user_id = ?
";
$params = [$user_id];
$favorites = $db->query($favorites_sql, $params);

$db->close();
?>


<!DOCTYPE html>
<html lang="en">
<?php
$title = "| Favorites";
include "../../constants.php";
include "../../components/head.php";
?>

<body>
    <div class="container">
        <!-- navigation -->
        <?php include "../../components/navbar.php"; ?>

        <!-- Display favorite articles -->
        <section class="margin-ys">
            <h1>Your Favorite Articles</h1>
            <div class="list-section" id="favorites-list">
                <?php
                if ($favorites) {
                    foreach ($favorites as $article) {
                        $articleId = $article['id'];
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
                }
                ?>
            </div>
        </section>
    </div>

    <!-- footer -->
    <?php include "../../components/footer.php"; ?>
</body>

</html>