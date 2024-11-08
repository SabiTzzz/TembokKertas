<?php
include '../koneksi.php';

session_start();

if (!$_SESSION["login"]) {
    header("Location: ../akun/login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: ../utama/beranda.php");
    exit;
}

$result = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM akun");
$row = mysqli_fetch_assoc($result);
$jumlah_user = $row['jumlah'];

$wallpaper = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM wallpaper");
$row = mysqli_fetch_assoc($wallpaper);
$jumlah_wallpaper = $row['jumlah'];

$tag = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM tag_detail");
$row = mysqli_fetch_assoc($tag);
$jumlah_tag = $row['jumlah'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <?php require '../element/navbar_admin.php'; ?>
    <section class="sec-header">
        <div class="header">
            <h1>Welcome Admin</h1>
            <p>Here you can see all the information about the user and the seller</p>
        </div>
    </section>
    <section>
        <div class="menu_area">
            <div class="menu_grid">
                <div class="menu_box" onclick="location.href='user_information.php';">
                    <div class="menu_logo">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="menu_name">
                    <a>Informasi User</a>
                        <span><?php echo "Akun terdaftar: " . $jumlah_user; ?></span>
                    </div>
                    
                </div>
                <div class="menu_box" onclick="location.href= 'wallpaper_information.php';">
                    <div class="menu_logo">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div class="menu_name">
                        <a>Data Wallpaper</a>
                        <span><?php echo "Jumlah Wallpaper: " . $jumlah_wallpaper; ?></span>
                    </div>
                </div>
                <div class="menu_box" onclick="location.href='tag_information.php';">
                    <div class="menu_logo">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div class="menu_name">
                        <a>Tag Information</a>
                        <span><?php echo "Jumlah Tag: " . $jumlah_tag; ?></span>
                    </div>
                </div>
                <div class="menu_box" onclick="if (confirm('Apakah Anda yakin ingin logout?')) { location.href='../akun/logout.php'; }">
                    <div class="menu_logo">
                        <i class="fa-solid fa-sign-out"></i>
                    </div>
                    <div class="menu_name">
                        <a>Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>