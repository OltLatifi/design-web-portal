<?php
session_start();
if (!$_SESSION["role"] || !(strtoupper($_SESSION["role"]) == "ADMIN")) {
    header("Location: " . PROJECT_URL);
    die();
}

$title = "| Dashboard";
include "../../constants.php";
include "../../database/connection.php";
include "../../meta/PersonnelManager.php";

class Personnel extends PersonnelMannager {
    public function deleteById($id){
        $sql = "DELETE FROM user WHERE id = ?";
        $params = ['s', $id];
        return $this->db->query($sql, $params);
    }
}

$personnel_obj = new Personnel($db);
$personnels = $personnel_obj->list();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $personnel = $personnel_obj->deleteById($_POST["id"]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
    include "../../components/head.php";
?>

<body>
    <div class="container" style="min-height: 70dvh;">
        <!-- nav -->
        <?php
            include "../../components/adminnavbar.php";
        ?>
        <table class="margin-ys">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (count($personnels) > 0){
                        foreach ($personnels as $personnel) {
                            $id = $personnel['id'];
                            $first_name = $personnel['first_name'];
                            $last_name = $personnel['last_name'];
                            $email = $personnel['email'];
                            $role = $personnel['role'];
                            echo "
                                <tr>
                                    <td>$id</td>
                                    <td>$first_name</td>
                                    <td>$last_name</td>
                                    <td>$email</td>
                                    <td>$role</td>"
                                    . (strtoupper($role) != "ADMIN"
                                        ? "<td><button onclick='deleteUser($id)'>Delete</button></td>"
                                        : "<td>This user cannot be deleted</td>")
                                    . "
                                </tr>";

                        }
                    } else {
                        echo "<tr><td colspan='100%' style='text-align: center;'>You don't have any published personnels left</td></tr>";
                    }
                ?>
            </tbody>
        </table>

</div>

<!-- footer -->
<?php
  include "../../components/footer.php";
?>

<script>
function deleteUser(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'dashboard.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            window.location.reload()
        }
    };

    let data = 'id=' + encodeURIComponent(id);

    xhr.send(data);
}
</script>
</body>
</html>
