<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "STAFF")) {
    header("Location: " . PROJECT_URL);
    die();
}

$title = "| Dashboard";
include "../../constants.php";
include "../../database/connection.php";
include "meta/ArticleManager.php";


$drafts = new ArticleManager($db);
$articles = $drafts->list(null);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["id"]) && isset($_POST["status"])){
        $newStatus = filter_var($_POST["status"], FILTER_VALIDATE_BOOLEAN);
        $article = $drafts->changeStatus($_POST["id"], $newStatus);
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
            include "../../components/navbar.php";
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
                                        <button onclick='unpublish($id)'>Edit</button>
                                        <button onclick='unpublish($id)'>Delete</button>
                                        <button onclick='toggle($id, $status)'>Toggle Status</button>
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
function toggle(id, status) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'dashboard.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            window.location.reload()
        }
    };

    let data = 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(!status);

    xhr.send(data);
}
</script>
</body>
</html>
