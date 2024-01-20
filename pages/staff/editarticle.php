<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../constants.php";
include "../../database/connection.php";
session_start();

if (!isset($_SESSION["role"]) || strtoupper($_SESSION["role"]) !== "STAFF") {
    header("Location: " . PROJECT_URL);
    exit();
}

class Article {
    private $db;
    private $sql = "UPDATE article SET title = ?, image = ?, content = ?, status = ? WHERE id = ?";
    public $title, $content, $status = 0;
    public $imagePath;
    private $articleId;
    private $authorId;

    public function __construct($db) {
        $this->db = $db;

        // Get the article ID from the URL
        if (isset($_GET["id"])) {
            $this->articleId = $_GET["id"];
        }

        // Fetch existing article data for editing
        $this->getArticleData();

        if ($_SESSION["user_id"] != $this->authorId) {
            $this->redirectToErrorPage();
        }
    }

    public function getArticleData() {
        // Check if article ID is set
        if ($this->articleId) {
            $sql = "SELECT * FROM article WHERE id = ?";
            $params = ['s', $this->articleId];

            $result = $this->db->query($sql, $params);

            if ($result && count($result) > 0) {
                $this->title = "OLTI UPDATED";
                $this->imagePath = "olti";
                $this->content = $result[0]["content"];
                $this->status = $result[0]["status"];
                $this->authorId = $result[0]["author_id"];
            } else {
                $this->redirectToErrorPage();
            }

            return $result;
        }
    }

    public function save() {
        echo "Parameters: " . $this->title . ", " . $this->imagePath . ", " . $this->content . ", " . $this->status . ", " . $_GET["id"] . "\n";

        echo "SQL Query: " . $this->sql . "\n";
        $stmt = $this->db->getConn()->prepare($this->sql);
        $stmt->bind_param("sssii", $this->title, $this->imagePath, $this->content, $this->status, $_GET["id"]);
        return $stmt->sql;
        if ($stmt->execute()) {
          $stmt->close();
        //   $_POST = array();
          return ["success" => true];
        } else {
          return ["error" => "Database error: " . $stmt->error];
        }
    }

    private function redirectToErrorPage() {
        header("Location: " . PROJECT_URL . "pages/staff/error.php");
        exit();
    }
}

$titleError = $imageError = $contentError = "";
$article = new Article($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $success = $article->save();
    print_r($success);
}

print_r($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = "| Edit Article";
include "../../components/head.php";
?>
<body>
<div class="container">
    <!-- nav -->
    <?php include "../../components/navbar.php"; ?>
    <!-- form -->
    <div style="display: none;" class="alert <?php echo $success["success"] ? 'alert-primary' : 'alert-error' ?>">
        <?php echo $alertMessage ?>
    </div>
    <main class="form-layout margin-ys min-height-l">
        <form id="form" class="form" method="POST" enctype="multipart/form-data">
            <h1>Edit Article</h1>
            <label>
                Title:
                <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($article->title); ?>"/>
                <p class="error" id="title_error"><?php echo $titleError ?></p>
            </label>
            <label>
                Image:
                <input id="image" type="file" name="image"/>
                <p class="error" id="image_error"><?php echo $imageError ?></p>
            </label>
            <label>
                Content:
                <textarea rows="5" id="content" type="text" name="content"><?php echo htmlspecialchars($article->content); ?></textarea>
                <p class="error" id="content_error"><?php echo $contentError ?></p>
            </label>
            <button type="submit">Update</button>
        </form>
        <div>
            <img src="<?php echo PROJECT_URL ?>/assets/article.webp" alt="Article image">
        </div>
    </main>
</div>

<!-- footer -->
<?php include "../../components/footer.php"; ?>
</body>
<script>
    let title_error = document.getElementById("title_error");
    let image_error = document.getElementById("image_error");
    let content_error = document.getElementById("content_error");
    let alert = document.querySelector(".alert");

    if (title_error.innerHTML.trim() !== "") {
      title_error.classList.add("show");
    }
    if (image_error.innerHTML.trim() !== "") {
      image_error.classList.add("show");
    }
    if (content_error.innerHTML.trim() !== "") {
      content_error.classList.add("show");
    }
    if (alert.innerHTML.trim() !== "") {
      alert.classList.add("show");
    }

    function resetState(event) {
      let id = event.target.id;
      document.querySelector(`#${id}_error`).classList.remove("show");
    }

    let inputs = document.querySelectorAll("input, textarea");
    inputs.forEach((element) => {
      element.addEventListener("change", resetState);
    });
</script>
</html>
