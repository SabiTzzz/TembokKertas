<?php
    session_start();
    include '../koneksi.php';

    if (!$_SESSION["login"]) {
        header("Location: ../akun/login.php");
        exit;
    }
    
    if ($_SESSION["role"] !== "admin") {
        header("Location: ../utama/beranda.php");
        exit;
    }

    $sql = "SELECT wallpaper.id, wallpaper.path, wallpaper.nama, wallpaper.deskripsi, akun.username, GROUP_CONCAT(tag_detail.jenis SEPARATOR ', ') as tags
            FROM wallpaper
            JOIN akun ON wallpaper.id_user = akun.id
            JOIN tag ON wallpaper.id = tag.id_wallpaper
            JOIN tag_detail ON tag.id_tag_detail = tag_detail.id
            GROUP BY wallpaper.id";

    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallpaper Data</title>
    <link rel="stylesheet" href="../element/style.css">
</head>
<body>
    <?php require '../element/navbar_admin.php'; ?>
    <section class="wallpaper-service-section">
        <h1 class="h1-tag">Wallpaper Information</h1>
        <section class="search-section">
            <div class="search-bar">
                <input type="text" name="keyword" id="keyword" placeholder="Searching...">
            </div>
        </section>
        <div class="tag-content">
            <div class="backtoadmin">
                <a href="berandaatmin.php">Back</a>
            </div>
            <table border="2" class="wallpaper_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Wallpaper</th>
                        <th>Nama Wallpaper</th>
                        <th>Deskripsi</th>
                        <th>Tags</th>
                        <th>Pemilik</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        $rows = $result->fetch_all(MYSQLI_ASSOC);
                        $i = 1;
                        foreach($rows as $row) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><img src="<?= $row['path'] ?>" class="img-table" alt="<?= $row['nama'] ?>"width="500"></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['deskripsi'] ?></td>
                        <td><?= $row['tags'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td>                        
                            <button>
                                <a href="delete_wallpaper.php?id=<?= $row['id'] ?>" class="action">Hapus</a>
                            </button>
                        </td>
                    </tr>
                    <?php $i++; } 
                        } else {
                            echo "<p>No wallpapers found.</p>";
                        }
                        $conn->close();
                        ?>
                </tbody>
            </div>
        </table>
    </section>
</body>
</html>
