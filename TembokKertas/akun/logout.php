<?php
    echo 
    "<script>
    if(confirm('Are you sure you want to logout?')) {
        document.location.href = '../akun/logout.php';
    } else {
        document.location.href = '#';
    }
    </script>";
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../utama/beranda.php");
    exit;
?>