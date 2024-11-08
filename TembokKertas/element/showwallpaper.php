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
    
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    if ($keyword) {
        $query = "SELECT wallpaper.id, wallpaper.path, wallpaper.nama, wallpaper.deskripsi, akun.username, GROUP_CONCAT(tag_detail.jenis SEPARATOR ', ') as tags
            FROM wallpaper
            JOIN akun ON wallpaper.id_user = akun.id
            JOIN tag ON wallpaper.id = tag.id_wallpaper
            JOIN tag_detail ON tag.id_tag_detail = tag_detail.id
            WHERE wallpaper.nama LIKE '%$keyword%' OR wallpaper.deskripsi LIKE '%$keyword%' OR akun.username LIKE '%$keyword%'
            GROUP BY wallpaper.id";
        $result = mysqli_query($conn, $query);
    } else {
        $result = mysqli_query($conn,"SELECT wallpaper.id, wallpaper.path, wallpaper.nama, wallpaper.deskripsi, akun.username, GROUP_CONCAT(tag_detail.jenis SEPARATOR ', ') as tags
                                        FROM wallpaper
                                        JOIN akun ON wallpaper.id_user = akun.id
                                        JOIN tag ON wallpaper.id = tag.id_wallpaper
                                        JOIN tag_detail ON tag.id_tag_detail = tag_detail.id
                                        GROUP BY wallpaper.id");
    }
?>

<div class="tag-content" id="wallpaper-table">
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
                <td><img src="<?= $row['path'] ?>" alt="<?= $row['nama'] ?>"width="500"></td>
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
    </table>
</div>