<!DOCTYPE html>
<html lang="en">
  <?php
    $title = "| About us";
    include "../../constants.php";
    include "../../components/head.php";

    $aboutUsContent = $db->query("SELECT * FROM about_us ORDER BY id DESC LIMIT 1");

    if ($aboutUsContent) {
        $aboutUsContent = $aboutUsContent[0]['content'];
    } else {
        $aboutUsContent = "No content available.";
    }
  ?>

  <body>
    <div class="container">
      <!-- navigation -->
      <?php
        include "../../components/navbar.php";
      ?>

      <div>
        <h1 class="margin-ys">Lorem ipsum</h1>
        <p class="about-us-paragraphs">
          <?php echo $aboutUsContent; ?>
        </p>
        <h2>Lorem ipsum</h2>
        <p class="about-us-paragraphs">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip ex ea commodo consequat. Duis aute irure dolor in
          reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
          pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
          culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum
          dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
          incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
          commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
          velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
          occaecat cupidatat non proident, sunt in culpa qui officia deserunt
          mollit anim id est laborum.
        </p>
        <h2>Lorem ipsum</h2>
        <p class="about-us-paragraphs">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip ex ea commodo consequat. Duis aute irure dolor in
          reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
          pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
          culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum
          dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
          incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
          commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
          velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
          occaecat cupidatat non proident, sunt in culpa qui officia deserunt
          mollit anim id est laborum.
        </p>
      </div>
    </div>
    <!-- footer -->
    <?php
      include "../../components/footer.php";
    ?>
  </body>
</html>
