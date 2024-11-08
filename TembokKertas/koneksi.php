<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db_nama = "dbwc" ;

    $conn = mysqli_connect($server, $user, $password, $db_nama);

    if (!$conn) {
        die("Koneksi Gagal : " . mysqli_connect_error());
    }

?>