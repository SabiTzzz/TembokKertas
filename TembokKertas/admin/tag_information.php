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

    $sql = "SELECT tag_detail.jenis, count(tag.id_wallpaper) as jumlah_wallpaper FROM tag_detail JOIN tag ON tag.id_tag_detail = tag_detail.id GROUP BY tag_detail.jenis";

    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../element/style.css">
</head>
<body>
    <?php require '../element/navbar_admin.php'; ?>
    <section class="tag-section">
        <h1 class="h1-tag">Tag Information</h1>
        <div class="tag-content">
            <div class="backtoadmin">
                <a href="berandaatmin.php">Back</a>
            </div>
            <table border="2" class="tag_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tag</th>
                        <th>Jumlah wallpaper</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        $rows = $result->fetch_all(MYSQLI_ASSOC);
                        $i = 1;
                        foreach($rows as $row) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['jenis'] ?></td>
                        <td><?= $row['jumlah_wallpaper'] ?></td>
                    </tr>
                    <?php $i++; } 
                        } else {
                        echo "<p>No wallpapers found.</p>";
                        }
                        $conn->close();
                        ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>