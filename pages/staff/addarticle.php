<?php

include "../../constants.php";
include "../../database/connection.php";
session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "STAFF")) {
  header("Location: " . PROJECT_URL);
  die();
}

class Article {
  private $db;
  private $sql = "
    INSERT INTO article (author_id, title, image, content, status)
    VALUES (?, ?, ?, ?, ?)";
  private $title, $content, $status= 0;
  private $imagePath;

  public function __construct($db) {
    $this->db = $db;
    $this->title = $_POST["title"];
    $this->content = $_POST["content"];
  }

    public function validateInputs(){
      $errors = [
        "error" => false,
        "title" => "",
        "content" => ""
      ];

      if(empty(trim($this->title))){
        $errors["title"] = "Title cannot be empty";
        $errors["error"] = true;
      }
      if(empty(trim($this->content))){
        $errors["content"] = "Content cannot be empty";
        $errors["error"] = true;
      }

      return $errors;
    }

    public function saveMedia(){
      $imagename = $_FILES['image']['name'];
      $imagetype = $_FILES['image']['type'];
      $imageerror = $_FILES['image']['error'];
      $imagetemp = $_FILES['image']['tmp_name'];

      $this->imagePath = "/images/" . $imagename;
  
      $data = [
          "error" => false,
          "message" => ""
      ];
  
      if(is_uploaded_file($imagetemp)) {
        if(move_uploaded_file($imagetemp, $_SERVER['DOCUMENT_ROOT'] . $this->imagePath)) {
          $data["message"] = "Sussecfully uploaded your image.";
        } else {
          $data["message"] = "Failed to move your image.";
          $data["error"] = true;
        }
      } else {
        $data["message"] = "Failed to upload your image.";
        $data["error"] = true;
      }

      return $data;
    }

  public function save(){
    $validation = $this->validateInputs();
    if ($validation["error"]) {
      return ["success" => false];
    }

    $imageUpload = $this->saveMedia();
    if($imageUpload["error"]){
      return ["success" => false];
    }
    $stmt = $this->db->getConn()->prepare($this->sql);
    $stmt->bind_param("isssi", $_SESSION["user_id"], $this->title, $this->imagePath, $this->content, $this->status);

    if ($stmt->execute()) {
      $stmt->close();
      $_POST = array();
      return ["success" => true];
    } else {
      return ["error" => "Database error: " . $stmt->error];
    }
  }
}

$titleError = $imageError = $contentError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $article = new Article($db);
  $errors = $article->validateInputs();
  
  $titleError = $errors["title"];
  $contentError = $errors["content"];

  $success = $article->save();
  if($success["success"]){ 
    $alertMessage = "Article Created Succesfully";
  } else {
    $alertMessage = "Check the errors under the fields";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
  $title = "| Add Article";
  include "../../components/head.php";
?>
<body>
<div class="container">
  <!-- nav -->
  <?php
    include "../../components/staffnavbar.php";
  ?>
  <!-- form -->
  <div style="display: none;" class="alert <?php echo $success["success"]?'alert-primary': 'alert-error'?> margin-ys">
    <?php echo $alertMessage ?>
  </div>
  <main class="form-layout margin-ys min-height-l">
    <form id="form" class="form" method="POST" enctype="multipart/form-data">
      <h1>Add Article</h1>
      <label>
        Title:
        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($_POST['title']); ?>"/>
        <p class="error" id="title_error"><?php echo $titleError ?></p>
      </label>
      <label>
        Image:
        <input id="image" type="file" name="image" value="<?php echo $_POST['image']; ?>"/>
        <p class="error" id="image_error"><?php echo $imageError ?></p>
      </label>
      <label>
        Content:
        <textarea rows="5" id="content" type="text" name="content" value="<?php echo htmlspecialchars($_POST['content']); ?>"></textarea>
        <p class="error" id="content_error"><?php echo $contentError ?></p>
      </label>
      <button>Submit</button>
    </form>
    <div>
      <img src="<?php echo PROJECT_URL ?>/assets/article.webp" alt="Article image">
    </div>
  </main>
</div>

<!-- footer -->
<?php
  include "../../components/footer.php";
?>
</body>
<script>

    let title_error = document.getElementById("title_error");
    let image_error = document.getElementById("image_error");
    let content_error = document.getElementById("content_error");
    let alert = document.querySelector(".alert");

    if (title_error.innerHTML) {
      title_error.classList.add("show");
    }
    if (image_error.innerHTML) {
      image_error.classList.add("show");
    }
    if (content_error.innerHTML) {
      content_error.classList.add("show");
    }
    if (alert.innerHTML.trim() == "") {
      alert.classList.remove("show");
    } else {
      alert.classList.add("show");
    }

    function resetState(event) {
      let id = event.target.id;
      document.querySelector(`#${id}_error`).classList.remove("show");
    }
    let inputs = document.querySelectorAll("input");
    inputs.forEach((element) => {
      element.addEventListener("change", resetState);
    });

</script>
</html>
