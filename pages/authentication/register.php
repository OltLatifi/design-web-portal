<?php
  $title = "| Register";
  include "../../database/connection.php";
  include "../../constants.php";

  session_start();

  if($_SESSION["user_id"]){
    header("Location: " . PROJECT_URL);
    die();
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
        <form id="form" class="form" action="new_user.php">
          <h1>Register</h1>
          <p>
            Already have an account?
            <a href="login.html" style="color: dodgerblue">Log in</a>
          </p>
          <label>
            Username:
            <input id="username" type="text" />
            <p class="error" id="username_error"></p>
          </label>
          <label>
            First Name:
            <input id="first_name" type="text" />
            <p class="error" id="first_name_error"></p>
          </label>
          <label>
            Last name:
            <input id="last_name" type="text" />
            <p class="error" id="last_name_error"></p>
          </label>
          <label>
            Email:
            <input id="email" type="text" />
            <p class="error" id="email_error"></p>
          </label>
          <label>
            Password:
            <input id="password" type="password" />
            <p class="error" id="password_error"></p>
          </label>
          <label>
            Confirm Password:
            <input id="confirm_password" type="password" />
            <p class="error" id="confirm_password_error"></p>
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
    let form = document.getElementById("form");
    const usernameRegex = /^[A-Z][a-z]+[A-Z][a-z]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex =
      /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+,\-./:;<=>?@[\\]^_`{|}~]).{8,}$/;

    let username = document.getElementById("username");
    let firstName= = document.getElementById("first_name");
    let lastName = document.getElementById("last_name");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let confirm_password = document.getElementById("confirm_password");

    let username_error = document.getElementById("username_error");
    let firstName_error = document.getElementById("first_name_error");
    let lastName_error = document.getElementById("last_name_error");
    let email_error = document.getElementById("email_error");
    let password_error = document.getElementById("password_error");
    let confirm_password_error = document.getElementById(
      "confirm_password_error"
    );

    function submitForm(event) {
      event.preventDefault();

      if (username.value.trim() === "") {
        username_error.classList.add("show");
        username_error.innerHTML = "Username is a required field";
      } else if (!username.value.match(usernameRegex)) {
        username_error.classList.add("show");
        username_error.innerHTML =
          "Username should be camelcase (i.e OltLatifi, JohnDoe)";
      } else {
        username_error.classList.remove("show");
      }

      if (firstName.value.trim() === "") {
        firstName_error.classList.add("show");
        firstName_error.innerHTML = "First name is a required field";
      } else {
        firstName_error.classList.remove("show");
      }

      if (lastName.value.trim() === "") {
        lastName_error.classList.add("show");
        lastName_error.innerHTML = "Last name is a required field";
      } else {
        lastName_error.classList.remove("show");
      }

      if (email.value.trim() === "") {
        email_error.classList.add("show");
        email_error.innerHTML = "Email is a required field";
      } else if (!email.value.match(emailRegex)) {
        email_error.classList.add("show");
        email_error.innerHTML = "Please enter a valid email";
      } else {
        email_error.classList.remove("show");
      }

      if (password.value.trim() === "") {
        password_error.classList.add("show");
        password_error.innerHTML = "Password is a required field";
      } else if (!password.value.match(passwordRegex)) {
        password_error.classList.add("show");
        password_error.innerHTML =
          "Password should contain at least 8 characters, uppercase and lower case characters, numbers and symbols";
      } else {
        password_error.classList.remove("show");
      }

      if (confirm_password.value.trim() === "") {
        confirm_password_error.classList.add("show");
        confirm_password_error.innerHTML =
          "Confirm password is a required field";
      } else if (!(confirm_password.value === password.value)) {
        confirm_password_error.classList.add("show");
        confirm_password_error.innerHTML =
          "Confirm password should match with password";
      } else {
        confirm_password.classList.remove("show");
      }
    }
    form.addEventListener("submit", submitForm);

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
