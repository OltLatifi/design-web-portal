<?php
  $title = "| Login";
  include "../../database/connection.php";
  include "../../constants.php";

  session_start();

  if($_SESSION["user_id"]){
    header("Location: " . PROJECT_URL);
    die();
  }

  class Login {
    private $db;

    public function __construct($db, $projectUrl) {
      $this->db = $db;
      $this->projectUrl = $projectUrl;
    }

    public function authenticateUser($username, $password){
      $sql = "SELECT id, username, password, role FROM user WHERE username = ? OR email = ?";
      $stmt = $this->db->getConn()->prepare($sql);
      $stmt->bind_param("ss", $username, $username);
      $stmt->execute();
      $stmt->bind_result($userId, $dbUsername, $dbPassword, $dbRole);

      if ($stmt->fetch()) {
        if (password_verify($password, $dbPassword)) {
          $this->startSession($userId, $dbUsername, $dbRole);
          $this->redirectUser($dbRole);
        } else {
          $passwordError =  "Incorrect password";
        }
      } else {
        $usernameError =  "User not found";
      }

      $stmt->close();
      return ["usernameError" => $usernameError, "passwordError" => $passwordError];
    }

    private function startSession($userId, $username, $role) {
      session_start();
      $_SESSION['user_id'] = $userId;
      $_SESSION['username'] = $username;
      $_SESSION['role'] = $role;
    }

    private function redirectUser($role) {
      if (strtoupper($role) == 'ADMIN') {
        header("Location: " . $this->projectUrl . "pages/admin/dashboard.php");
        die();
      } elseif (strtoupper($role) == 'STAFF') {
        header("Location: " . $this->projectUrl . "pages/staff/dashboard.php");
        die();
      } else {
        header("Location: " . $this->projectUrl . "index.php");
        die();
      }
    }
  }

  $login = new Login($db, PROJECT_URL);

  $usernameError = $passwordError = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = $login->authenticateUser($username, $password);
    $usernameError = $errors["usernameError"];
    $passwordError = $errors["passwordError"];
  }
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    include "../../components/head.php";
  ?>
  <body>
    <div class="container">
      <!-- nav -->
      <?php
        include "../../components/navbar.php";
      ?>
      <!-- form -->
      <main class="form-layout margin-ys">
        <form id="form" class="form" method="POST">
          <h1>Login</h1>
          <p class="my-s" style="font-family: var(--font-secondary)">Don't have an account? <a href="register.php" style="color: blue">Register here</a></p>
          <label>
            Username or Email:
            <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"/>
            <p class="error" id="username_error"><?php echo $usernameError ?></p>
          </label>
          <label>
            Password:
            <input id="password" type="password" name="password" value="<?php echo htmlspecialchars($password); ?>"/>
            <p class="error" id="password_error"><?php echo $passwordError ?></p>
          </label>
          <button>Submit</button>
        </form>
        <div>
          <img src="../../assets/display.jpeg" alt="Side Image" />
        </div>
      </main>
    </div>
    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
  <script>
    let username_error = document.getElementById("username_error");
    let password_error = document.getElementById("password_error");

    if (username_error.innerHTML){
      username_error.classList.add("show");
    }
    if (password_error.innerHTML){
      password_error.classList.add("show");
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
