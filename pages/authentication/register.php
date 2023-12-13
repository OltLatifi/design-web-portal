<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/utils.css" />
    <link rel="stylesheet" href="/specific.css" />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="/assets/favicon.ico"
    />
  </head>
  <body>
    <div class="container">
      <!-- nav -->
      <nav>
        <ul class="nav-list">
          <li><a href="/">Home</a></li>
          <li><a href="/pages/main/listview.html">News</a></li>
          <li class="active padding-s rounded-s">
            <a href="/pages/authentication/register.html">Register</a>
          </li>
        </ul>
        <div class="nav-list">
          <img src="../../assets/svg/search.svg" alt="Search icon" />
          <img
            src="../../assets/svg/hamburger-menu.svg"
            alt="Hamburger menu icon"
          />
        </div>
      </nav>
      <!-- form -->
      <main class="form-layout margin-ys">
        <form id="form" class="form">
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
          <img src="/assets/display.jpeg" alt="Side Image" />
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
    let form = document.getElementById("form");
    const usernameRegex = /^[A-Z][a-z]+[A-Z][a-z]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const passwordRegex =
      /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+,\-./:;<=>?@[\\]^_`{|}~]).{8,}$/;

    let username = document.getElementById("username");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let confirm_password = document.getElementById("confirm_password");

    let username_error = document.getElementById("username_error");
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
