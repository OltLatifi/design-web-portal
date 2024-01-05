<?php
  include "../../database/connection.php";
  include "../../constants.php";

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

  session_start();
  $login = new Login($db, $PROJECT_URL);

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
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../../style.css" />
    <link rel="stylesheet" href="../../utils.css" />
    <link rel="stylesheet" href="../../specific.css" />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="../../assets/favicon.ico"
    />
  </head>
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
    <footer>
      <div class="container footer-content">
        <div>
          <h4>About</h4>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac
            justo et mauris fermentum dapibus. Integer euismod vehicula ligula,
            eu ultrices lectus lacinia nec. Proin vestibulum justo nec metus
            tincidunt, ac posuere justo bibendum. Sed euismod finibus nisi, vel
            cursus ex euismod eget. Aenean sodales urna eu neque tincidunt, vel
            ultrices felis laoreet. Vivamus auctor nisl vel ante facilisis, non
            cursus eros rhoncus. Phasellus aliquet sapien in velit tincidunt
          </p>
        </div>

        <div>
          <h4>Quick Links</h4>
          <ul class="footer-links">
            <li><a href="/pages/main/aboutus.html">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Contribute</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>
      </div>
      <div class="container">
        <div>
          <div>
            <ul class="social-icons">
              <li>
                <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
              </li>
              <li>
                <a href="https://github.com/OltLatifi/design-web-portal"
                  ><i class="fa fa-github fa-lg"></i
                ></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
              </li>
            </ul>
          </div>
          <hr class="divider" />
          <p class="copyright-text">
            Copyright &copy; 2023 | All Rights Reserved
          </p>
        </div>
      </div>
    </footer>
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
