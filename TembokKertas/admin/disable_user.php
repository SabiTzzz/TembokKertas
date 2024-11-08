<?php
require "../koneksi.php";

$id = $_GET["id"];
$disable = $_GET["disable"];

if ($disable == 0) {
    $result = mysqli_query($conn, "UPDATE akun SET disable = 1 WHERE id = $id");
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
            document.location.href = 'user_information.php';
            </script>";
    } else {
        echo "<script>
            document.location.href = 'user_information.php';
            </script>";
    }
} else {
    $result = mysqli_query($conn, "UPDATE akun SET disable = 0 WHERE id = $id");
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
            document.location.href = 'user_information.php';
            </script>";
    } else {
        echo "<script>
            document.location.href = 'user_information.php';
            </script>";
    }
}
?>