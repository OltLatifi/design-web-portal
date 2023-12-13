<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Site | Latest News</title>
    <link
      href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
      rel="stylesheet"
    />
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
      <!-- navigation -->
      <?php
        include "/components/navbar.php";
      ?>

      <!-- slider -->
      <div id="slider" class="margin-ys">
        <button onclick="goPrevious()"><</button>
        <button onclick="goNext()">></button>
      </div>

      <!-- list section -->
      <section class="margin-ys">
        <h1>Latest News</h1>
        <div class="list-section" id="articles-list"></div>
      </section>
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

    <script src="slider.js" async defer />
  </body>
</html>
