<?php
	session_start();
	require '../koneksi.php';

    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/berandaatmin.php");
            exit();
        }
    }

    if(isset($_SESSION['username'])){
        $id = $_SESSION['id'];
    } else {
        header("Location: ../akun/login.php");
        exit();
    }

	$sql = "SELECT wallpaper.id AS id, wallpaper.path AS wallpaper, wallpaper.nama AS nama, akun.username AS user, akun.profile_picture AS picture FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id WHERE wallpaper.id_user = '$id'";
	$wallpaper_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Management</title>
    <link rel="stylesheet" href="../element/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"/>
</head>
<body class="profile">
    <?php require '../element/navbar.php'; ?>
    <section class="profile-container">
        <div class="profile-sidebar">
            <h2>User Profile Management</h2>
            <ul>
                <li>
                    <a class="profile-info" href="userprofil.php">
                        <i class="fas fa-fw fa-user"></i>Personal Info
                    </a>
                </li>
            <li>
                <a class="profile-edit" href="editprofil.php">
                    <i class="fas fa-fw fa-pen-to-square"></i>Profile Edit
                </a>
            </li>
            <li>
                <a class="profile-uploaded-active" href="upprofil.php">
                    <i class="fa-solid fa-fw fa-image"></i>Uploaded
                </a>
            </li>
            <li>
                <a class="profile-logout" href="../akun/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                    <i class="fa-solid fa-fw fa-right-from-bracket"></i>Logout
                </a>
            </li>
        </div>
        <div class="vertical-line"></div>
            <div class="profile-content">
                <div class="header-uploaded">
                    <h1>Uploaded Post</h1>
                    <div class="tambah-uploaded">
                        <h2>Upload Wallpaper</h2>
                        <a href="upload.php"><i class="fa-regular fa-fw fa-square-plus fa-2xl"></i></a>
                    </div>
                </div>
                <hr><br> 
                <div class="columns">
                    <?php
                    if ($wallpaper_result->num_rows > 0) {
                        $rows = $wallpaper_result->fetch_all(MYSQLI_ASSOC);
                        $direktori = '../asset/profile_picture/';
                        foreach($rows as $row) {
                            echo '<figure>';
                            echo '<img src="' . $row["wallpaper"] . '" alt="' . $row["nama"] . ' " class="display-wallpaper">';
                            echo '<div class="overlay" onclick="location.href=\'../utama/wallpaper.php?id='. $row['id'] .'\';">';
                            echo '<img src="' . $direktori . $row["picture"] .'" alt="' . $row["user"] . '" class="uploader-picture">';
                            echo '<p>' . $row["user"] . '</p>'; 	
                            echo '<div class="button">';
                            echo '<a href="editupprofil.php?id='. $row['id'] .'" class="edit-btn"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></a>';
                            echo '<a href="hapus_wallpaper.php?id='. $row['id'] .'" class="hapus-btn" onclick ="return confirm(\'Yakin ingin menghapus data?\');"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>';
                            echo '</div>';
                            echo '</figure>';
                        }
                    } else {
                        echo "<p>You haven't upload any wallpaper</p>";
                    }
                    $conn->close();
                    ?>
                    <small>Wallpaper &copy; <a href="../utama/aboutUs.php">TembokKertas</a></small>
                </div>
            </div>
        </div>
    </section>
</body>
</html>