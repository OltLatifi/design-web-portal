<?php

session_start();
if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "STAFF")) {
    header("Location: " . PROJECT_URL);
    die();
}

$title = "| Dashboard";
include "../../constants.php";
include "../../database/connection.php";
include "../../meta/ArticleManager.php";

class Article extends ArticleManager {
    public function deleteById($id){
        $sql = "DELETE FROM article WHERE id = ?";
        $params = ['s', $id];
        return $this->db->query($sql, $params);
    }
}

$article_obj = new Article($db, $_SESSION["user_id"]);
$articles = $article_obj->list(null);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        switch ($_POST["action"]) {
            case "TOGGLE":
                if (isset($_POST["id"]) && isset($_POST["status"])) {
                    $newStatus = filter_var($_POST["status"], FILTER_VALIDATE_BOOLEAN);
                    $article = $article_obj->changeStatus($_POST["id"], $newStatus);
                }
                break;
            case "DELETE":
                if (isset($_POST["id"])) {
                    $article = $article_obj->deleteById($_POST["id"]);
                }
                break;
        }
    }
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
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (count($articles) > 0){
                        foreach ($articles as $article) {
                            $id = $article['id'];
                            $title = $article['title'];
                            $status = $article['status'];
                            $created_at = date("F jS, Y", strtotime($article['created_at']));
                            echo "
                                <tr>
                                    <td>$id</td>
                                    <td>$title</td>
                                    <td>".($status? "Published": "Draft")."</td>
                                    <td>$created_at</td>
                                    <td>
                                        <button onclick='trigger($id, null, `DELETE`)'>Delete</button>
                                        <button onclick='trigger($id, $status, `TOGGLE`)'>Toggle Status</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='100%' style='text-align: center;'>You don't have any published articles left</td></tr>";
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
function trigger(id, status, action) {
    console.log(id, status, action)
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'dashboard.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            window.location.reload()
        }
    };

    let data = 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(!status) + '&action=' + encodeURIComponent(action);

    xhr.send(data);
}
</script>
</body>
</html>
