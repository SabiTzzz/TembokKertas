<?php
    require "../koneksi.php";
    if(isset($_GET["id"])) {
        $id = intval($_GET["id"]);
    }
    $delwallpaper = mysqli_query($conn, "SELECT path FROM wallpaper WHERE id = $id");
    $row = mysqli_fetch_assoc($delwallpaper);
    $wallpaper = $row['path'];

    $result = mysqli_query($conn, "DELETE FROM wallpaper WHERE id = $id");

    if (mysqli_affected_rows($conn) > 0) {
        $filePath = "asset/wallpaper/" . $wallpaper;
        unlink($filePath);
        echo "<script>
            alert('Data berhasil dihapus');
            document.location.href = 'wallpaper_information.php';
            </script>";

    } else {
        echo "<script>
            alert('Data gagal dihapus');
            document.location.href = 'wallpaper_information.php';
            </script>";
    }
?>