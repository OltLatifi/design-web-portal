<!DOCTYPE html>
<html lang="en">
<?php

$title = "| Edit About Us";
include "../../constants.php";
include "../../database/connection.php";
include "../../components/head.php";

session_start();

if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")) {
    header("Location: " . PROJECT_URL);
    die();
}

class AboutUs {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getData() {
        $sql = "SELECT content FROM about_us WHERE id = 1";
        return $this->db->query($sql)[0]['content'];
    }

    public function updateData() {
        $content = $_POST["content"];

        $sql = "UPDATE about_us SET content = ? WHERE id = 1";
        $params = ["s", $content];
    
        $stmt = $this->db->getConn()->prepare($sql);
        $stmt->bind_param(...$params);
        $stmt->execute();
    }
}

$aboutus_obj = new AboutUs($db);

$alert = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aboutus_obj->updateData();
    $alert = "About us edited succesfully";
}


include "../../components/adminnavbar.php";
?>

<body class="container">
    <div style="display: none;" class="alert alert-primary margin-ys">
        <?php echo $alert ?>
    </div>
    <main class="form-layout margin-ys min-height-l">
        <form id="form" class="form" method="POST">
            <h1>Edit About Us</h1>
            <label>
                New Content:
                <textarea name="content" rows="8" cols="50"><?php echo $aboutus_obj->getData(); ?></textarea>
            </label>
            <button>Submit</button>
        </form>
        <div>
            <img style="margin-left: -175px;" src="<?php echo PROJECT_URL ?>/assets/teamwork.png" alt="Teamwork image">
        </div>
    </main>

</body>
<script>

    let alert = document.querySelector(".alert");

    if (alert.innerHTML.trim() == "") {
        alert.classList.remove("show");
    } else {
        alert.classList.add("show");
    }

</script>
</html>
