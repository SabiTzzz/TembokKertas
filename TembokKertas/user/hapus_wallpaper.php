<?php
    session_start();
    require "../koneksi.php";

    $id = $_GET['id'];

    $tag_result = mysqli_query($conn, "DELETE FROM tag WHERE id_wallpaper = $id");
    $wallpaper_result = mysqli_query($conn, "DELETE FROM wallpaper WHERE id = $id");
    
    if($wallpaper_result && $tag_result){
        echo "
            <script>
                alert('Berhasil Menghapus Data Service!');
                document.location.href = 'upprofil.php';
            </script>";
    }
?>