<?php
  $title = "| Register";
  include "../../database/connection.php";
  include "../../constants.php";

  session_start();

  if($_SESSION["user_id"]){
    header("Location: " . PROJECT_URL);
    die();
  }

  class User {
    private $db;
    private $firstName, $lastName, $username, $email, $password, $confirmPassword;
  
    public function __construct($db) {
      $this->db = $db;
      $this->firstName = $_POST['firstName'];
      $this->lastName =$_POST['lastName'];
      $this->username = $_POST['username'];
      $this->email =$_POST['email'];
      $this->password =$_POST['password'];
      $this->confirmPassword =$_POST['confirmPassword'];
    }
  
    public function usernameExists(){
      $sql = "SELECT id FROM user WHERE username = ?";
      $stmt = $this->db->getConn()->prepare($sql);
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
  
      return $result->num_rows > 0;
    }
  
    public function emailExists(){
      $sql = "SELECT id FROM user WHERE email = ?";
      $stmt = $this->db->getConn()->prepare($sql);
      $stmt->bind_param("s", $this->email);
      $stmt->execute();
      $result = $stmt->get_result();
  
      return $result->num_rows > 0;
    }
  
    function hasError($array) {
      foreach ($array as $key => $value) {
        if($key == "error"){
          continue;
        }
  
        if (!empty($value)) {
          return true;
        }
      }
      return false;
    }
  
    public function validateInputs() {
      $errors = [
        "error"=>false,
        "firstName"=> "",
        "lastName"=> "",
        "username"=> "",
        "email"=> "",
        "password"=> "",
      ];
  
      if(empty(trim($this->firstName))){
        $errors["firstName"] = "First name cannot be empty";
      }
  
      if(empty(trim($this->lastName))){
        $errors["lastName"] = "Last name cannot be empty";
      }
  
      $usernameRegex = '/^[A-Z][a-z]+[A-Z][a-z]+$/';
      if(!preg_match($usernameRegex, $this->username)){
        $errors["username"] = "Username should be camel case";
      } 
      if ($this->usernameExists()) {
        $errors["username"] = "Username already exists";
      }
      
      $passwordRegex =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
      if(!preg_match($passwordRegex, $this->password)){
        $errors["password"] = "Password should be 8 characters, upper case, lower case, numbers and symbols";
      }
      
      if($this->password != $this->confirmPassword){
        $errors["password"] = "Password should match with confirm password";
      }
  
      $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
      if (!preg_match($emailRegex, $this->email)) {
        $errors["email"] = "Wrong email format";
      }
      if ($this->emailExists()) {
        $errors["email"] = "Email already exists";
      }
  
      $errors["error"] = $this->hasError($errors);
      return $errors;
    }
  
    public function save(){
      $sql = "INSERT INTO user (first_name, last_name, email, username, role, password) VALUES (?, ?, ?, ?, ?, ?)";
      $validation = $this->validateInputs();
      if ($validation["error"]) {
        return ["success" => false];
      }
  
      $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
      $role = "USER";
  
      $stmt = $this->db->getConn()->prepare($sql);
      $stmt->bind_param("ssssss", $this->firstName, $this->lastName, $this->email, $this->username, $role, $hashedPassword);
  
      if ($stmt->execute()) {
        $stmt->close();
        $_POST = array();
        return ["success" => true];
      } else {
        return ["error" => "Database error: " . $stmt->error];
      }
    }
  }

  $firstNameError = $lastNameError = $usernameError = $emailError = $passwordError = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new User($db);
  
    $errors = $user->validateInputs();
    
    $firstNameError = $errors["firstName"];
    $lastNameError = $errors["lastName"];
    $usernameError = $errors["username"];
    $emailError = $errors["email"];
    $passwordError = $errors["password"];
  
    $success = $user->save();
    if($success["success"]){ 
      header("Location: login.php");
      die();
    }
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
        <form id="form" class="form" method="post">
          <h1>Register</h1>
          <p>
            Already have an account?
            <a href="login.html" style="color: blue">Log in</a>
          </p>
          <label>
            Username:
            <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($_POST['username']) ?>"/>
            <p class="error" id="username_error"><?php echo $usernameError ?></p>
          </label>
          <label>
            First Name:
            <input id="first_name" type="text" name="firstName" value="<?php echo htmlspecialchars($_POST['firstName']) ?>"/>
            <p class="error" id="first_name_error"><?php echo $firstNameError ?></p>
          </label>
          <label>
            Last name:
            <input id="last_name" type="text" name="lastName" value="<?php echo htmlspecialchars($_POST['lastName']) ?>"/>
            <p class="error" id="last_name_error"><?php echo $lastNameError ?></p>
          </label>
          <label>
            Email:
            <input id="email" type="text" name="email" value="<?php echo htmlspecialchars($_POST['email']) ?>"/>
            <p class="error" id="email_error"><?php echo $emailError ?></p>
          </label>
          <label>
            Password:
            <input id="password" type="password" name="password" value="<?php echo htmlspecialchars($_POST['password']) ?>"/>
            <p class="error" id="password_error"><?php echo $passwordError ?></p>
          </label>
          <label>
            Confirm Password:
            <input id="confirm_password" type="password" name="confirmPassword" value="<?php echo htmlspecialchars($_POST['confirmPassword']) ?>"/>
          </label>
          <button>Submit</button>
        </form>
        <div>
          <img src="<?php echo PROJECT_URL . '/assets/display.jpeg' ?>" alt="Side Image" />
        </div>
      </main>
    </div>

    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
  <script>
    let first_name_error = document.getElementById("first_name_error");
    let last_name_error = document.getElementById("last_name_error");
    let username_error = document.getElementById("username_error");
    let email_error = document.getElementById("email_error");
    let password_error = document.getElementById("password_error");
    let alert = document.querySelector(".alert");

    if (first_name_error.innerHTML) {
      first_name_error.classList.add("show");
    }
    if (last_name_error.innerHTML) {
      last_name_error.classList.add("show");
    }
    if (username_error.innerHTML) {
      username_error.classList.add("show");
    }
    if (email_error.innerHTML) {
      email_error.classList.add("show");
    }
    if (password_error.innerHTML) {
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
