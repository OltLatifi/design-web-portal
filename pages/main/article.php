<!DOCTYPE html>
<html lang="en">
  <?php
    $title = "| News";
    include "../../constants.php";
    include "../../database/connection.php";
    include "../../components/head.php";
    include "../../meta/ArticleListManager.php";

    session_start();

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseURL = "{$protocol}://{$host}";
    
    $articleManager = new ArticleListManager($db);

    $id = $_GET['id'];

    class Favourite {
      private $db;
      private $articleId;
      private $userId;
  
      public function __construct(Database $db, $articleId, $userId) {
        $this->db = $db;
        $this->articleId = $articleId;
        $this->userId = $userId;
      }

      public function isAuthed(){
        return ($this->userId && $_SESSION["role"] == "USER");
      }

      public function checkSaved(){
        if(!$this->isAuthed()){
          return false;
        }

        $sql = "SELECT id FROM favorites WHERE user_id = ? AND article_id = ?";
        $params = ["ss", $this->userId, $this->articleId];

        $query = $this->db->query($sql, $params);
        if(!$query || count($query) < 1) {
          return false;
        }
        return true;
      }

      public function save(){
        if(!$this->isAuthed()){
          return false;
        }

        $sql = "INSERT INTO favorites (user_id, article_id) VALUES (?, ?)";
        $params = ["ss", $this->userId, $this->articleId];

        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param(...$params);
    
        if ($stmt->execute()) {
          print_r($stmt);
          $stmt->close();
          return ["success" => true];
        } else {
          return ["success" => false];
        }
      }
      public function remove(){
        if(!$this->isAuthed()){
          return false;
        }

        $sql = "DELETE FROM favorites WHERE user_id = ? AND article_id = ?";
        $params = ["ss", $this->userId, $this->articleId];

        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param(...$params);
    
        if ($stmt->execute()) {
          $stmt->close();
          return ["success" => true];
        } else {
          return ["success" => false];
        }
      }
    }

    $fav_object = new Favourite($db, $id, $_SESSION["user_id"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if($_POST["action"] == "add"){
        $fav_object->save();
      } else if($_POST["action"] == "remove"){
        $fav_object->remove();
      }
    }
  ?>
  <body>
    <div class="container">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <?php
        if(isset($id)){
          $article = $articleManager->getArticleById($id);
        } else {
          echo "'id' is a required query param";
        }
      ?>

      <!-- article section -->
      <main class="margin-ys">
        <h2 class="article-title"><?php echo $article["title"] ?></h2>
        <p class="article-author">Author: <?php echo $article["first_name"] ?> <?php echo $article["last_name"] ?> • <?php echo date("F jS, Y", strtotime($article['published_at'])) ?></p>
        <img class="article-image" src="<?php echo $baseURL . $article["image"] ?>"/>
        <pre class="article-content margin-ys"><?php echo $article["content"] ?></pre>
      </main>
      <?php
      if($fav_object->isAuthed()){
        if(!$fav_object->checkSaved()){
          echo "<form method='post'><input type='hidden' name='action' value='add' /><button>Add to favourites</button></form>";
        } else {
          echo "<form method='post'><input type='hidden' name='action' value='remove' /><button>Remove from favourites</button></form>";
        }
      }
      ?>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
</html>
