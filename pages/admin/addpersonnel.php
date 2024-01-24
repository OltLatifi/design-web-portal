<?php

include "../../constants.php";
include "../../database/connection.php";
session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")) {
  header("Location: " . PROJECT_URL);
  die();
}

class Personnel {
  private $db;
  private $sql = "INSERT INTO user (first_name, last_name, email, username, role, password) VALUES (?, ?, ?, ?, ?, ?)";
  private $firstName, $lastName, $newUsername, $email, $role, $password;

  public function __construct($db, $firstName, $lastName, $newUsername, $email, $role, $password) {
    $this->db = $db;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->newUsername = $newUsername;
    $this->email = $email;
    $this->role = $role;
    $this->password = $password;
  }

  public function usernameExists(){
    $sql = "SELECT id FROM user WHERE username = ?";
    $stmt = $this->db->getConn()->prepare($sql);
    $stmt->bind_param("s", $this->newUsername);
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
      "role"=> "",
      "password"=> "",
    ];

    if(empty(trim($this->firstName))){
      $errors["firstName"] = "First name cannot be empty";
    }

    if(empty(trim($this->lastName))){
      $errors["lastName"] = "Last name cannot be empty";
    }

    if(!in_array($this->role, ["STAFF", "ADMIN"])){
      $errors["role"] = "Role can either be Staff or Admin";
    }

    $newUsernameRegex = '/^[A-Z][a-z]+[A-Z][a-z]+$/';
    if(!preg_match($newUsernameRegex, $this->newUsername)){
      $errors["username"] = "Username should be camel case";
    } 
    if ($this->usernameExists()) {
      $errors["username"] = "Username already exists";
    }
    
    $passwordRegex =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
    if(!preg_match($passwordRegex, $this->password)){
      $errors["password"] = "Password should be 8 characters, upper case, lower case, numbers and symbols";
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
    $validation = $this->validateInputs();
    if ($validation["error"]) {
      return ["success" => false];
    }

    $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

    $stmt = $this->db->getConn()->prepare($this->sql);
    $stmt->bind_param("ssssss", $this->firstName, $this->lastName, $this->email, $this->newUsername, $this->role, $hashedPassword);

    if ($stmt->execute()) {
      $stmt->close();
      $_POST = array();
      return ["success" => true];
    } else {
      return ["error" => "Database error: " . $stmt->error];
    }
  }
}

$firstNameError = $lastNameError = $newUsernameError = $emailError = $roleError = $passwordError = "";
$alertMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $personnel = new Personnel(
    $db,
    $_POST['first_name'], 
    $_POST['last_name'],
    $_POST['username'],
    $_POST['email'],
    $_POST['role'],
    $_POST['password']
  );

  $errors = $personnel->validateInputs();
  
  $firstNameError = $errors["firstName"];
  $lastNameError = $errors["lastName"];
  $newUsernameError = $errors["username"];
  $emailError = $errors["email"];
  $roleError = $errors["role"];
  $passwordError = $errors["password"];

  $success = $personnel->save();
  if($success["success"]){ 
    $alertMessage = "Personnel Created Succesfully";
  } else {
    $alertMessage = "Check the errors under the fields";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
  $title = "| Add Personnel";
  include "../../components/head.php";
?>
<body>
<div class="container">
  <!-- nav -->
  <?php
    include "../../components/adminnavbar.php";
  ?>
  <!-- form -->
  <div style="display: none;" class="alert <?php echo $success["success"]?'alert-primary': 'alert-error'?> margin-ys">
    <?php echo $alertMessage ?>
  </div>
  <main class="form-layout margin-ys min-height-l">
    <form id="form" class="form" method="POST">
      <h1>Add Personnel</h1>
      <label>
        First Name:
        <input id="first_name" type="text" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name']); ?>"/>
        <p class="error" id="first_name_error"><?php echo $firstNameError ?></p>
      </label>
      <label>
        Last Name:
        <input id="last_name" type="text" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name']); ?>"/>
        <p class="error" id="last_name_error"><?php echo $lastNameError ?></p>
      </label>
      <label>
        Username:
        <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>"/>
        <p class="error" id="username_error"><?php echo $newUsernameError ?></p>
      </label>
      <label>
        Email:
        <input id="email" type="text" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>"/>
        <p class="error" id="email_error"><?php echo $emailError ?></p>
      </label>
      <label>
        Role:
        <select name="role" id="role">
          <option value="STAFF" <?php echo ($_POST['role'] === "STAFF") ? "selected" : ""; ?>>Staff</option>
          <option value="ADMIN" <?php echo ($_POST['role'] === "ADMIN") ? "selected" : ""; ?>>Admin</option>
        </select>
        <p class="error" id="role_error"><?php echo $roleError ?></p>
      </label>
      <label>
        Password:
        <input id="password" type="password" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>"/>
        <p class="error" id="password_error"><?php echo $passwordError ?></p>
      </label>
      <button>Submit</button>
    </form>
    <div>
      <img style="margin-left: -175px;" src="<?php echo PROJECT_URL ?>/assets/teamwork.png" alt="Teamwork image">
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
    let role_error = document.getElementById("role_error");
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
    if (role_error.innerHTML) {
      role_error.classList.add("show");
    }
    if (password_error.innerHTML) {
      password_error.classList.add("show");
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
