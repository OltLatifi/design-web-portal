<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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
      <?php
        include "/components/navbar.php";
      ?>
      <!-- form -->
      <main class="form-layout margin-ys">
        <form id="form" class="form">
          <h1>Login</h1>
          <label>
            Username or Email:
            <input id="username" type="text" />
            <p class="error" id="username_error"></p>
          </label>
          <label>
            Password:
            <input id="password" type="password" />
            <p class="error" id="password_error"></p>
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
    let username = document.getElementById("username");
    let password = document.getElementById("password");

    let username_error = document.getElementById("username_error");
    let password_error = document.getElementById("password_error");

    function submitForm(event) {
      event.preventDefault();
      let error = 0;

      if (
        username.value === "OltLatifi" ||
        username.value === "oltlatifi2003@gmail"
      ) {
        username_error.classList.remove("show");
        if (error > 0) {
          error--;
        }
      } else {
        username_error.classList.add("show");
        username_error.innerHTML = "Username is not correct";
        error++;
      }

      if (password.value === "Danke123") {
        password_error.classList.remove("show");
      } else {
        password_error.classList.add("show");
        password_error.innerHTML = "Password is not correct";
        error++;
      }

      if (error === 0) {
        alert("You are now logged in");
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