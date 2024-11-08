<?php
    session_start();
    require '../koneksi.php';
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/berandaatmin.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <?php include '../element/navbar.php'; ?>
    <section class="judul-au">
        <div class="aboutusLogo">
            <img src="../asset/LOGO.png" alt="Logo Kami">
        </div>
        <h1>TembokKertas</h1>
        <div class="subjudul-au">
            <p>About Us</p>
        </div>
    </section>
    <section class="aboutusBox">
        <div class="aboutusContent">
            <p>Website ini menyediakan berbagai wallpaper yang bisa digunakan bagi semua orang.</p> <br>
            <p>Website ini menyediakan berbagai wallpaper yang bisa digunakan bagi semua orang.</p> <br>
            <p>Website ini menyediakan berbagai wallpaper yang bisa digunakan bagi semua orang.</p> <br>
        </div>
    </section>
    <section class="aboutusCard">  
        <div class="judul-aucard">
            <h1>Our Team</h1>
        </div>
        <div class="profileanggota">
            <div class="deskanggota">
                <img src="../asset/ammar.jpg" alt="">
                <h1>Ammar Nabil F</h1>
            </div>
            <div class="deskanggota">
                <img src="../asset/arya.jpg" alt="">
                <h1>Muhammad Arya F R</h1>
            </div>
            <div class="deskanggota">
                <img src="../asset/jorip.jpg" alt="">
                <h1>Zhorif Fachdiat</h1>
            </div>
        </div>
    </section>
    <?php include '../element/footer.php'; ?>
</body>
<script src="../element/script.js"></script>
</html>