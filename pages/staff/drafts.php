<?php

session_start();
if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "STAFF")) {
    header("Location: " . PROJECT_URL);
    die();
}

$title = "| Drafts";
include "../../constants.php";
include "../../database/connection.php";
include "../../meta/ArticleManager.php";

$drafts = new ArticleManager($db);
$articles = $drafts->list(0);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])){
    $article = $drafts->changeStatus($_POST["id"], 1);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
    include "../../components/head.php";
?>

<body>
    <div class="container" style="min-height: 70dvh;">
        <!-- nav -->
        <?php
            include "../../components/staffnavbar.php";
        ?>
        <table class="margin-ys">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date Created</th>
                    <th>Publish</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (count($articles) > 0){
                        foreach ($articles as $article) {
                            $id = $article['id'];
                            $title = $article['title'];
                            $created_at = date("F jS, Y", strtotime($article['created_at']));
                            echo "<tr><td>$id</td><td>$title</td><td>$created_at</td><td><button onclick='publish($id)'>Publish</button></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='100%' style='text-align: center;'>You don't have any drafts left</td></tr>";

                    }
                ?>
            </tbody>
        </table>

</div>

<!-- footer -->
<?php
  include "../../components/footer.php";
?>

<script>
function publish(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'drafts.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            window.location.reload()
        }
    };

    let data = 'id=' + encodeURIComponent(id);

    xhr.send(data);
}
</script>
</body>
</html>
