<?php
    require "../koneksi.php";
    session_start();

    if (!$_SESSION["login"]) {
        header("Location: ../akun/login.php");
        exit;
    }
    if ($_SESSION["role"] !== "admin") {
        header("Location: ../utama/beranda.php");
        exit;
    }

    $result = mysqli_query($conn, "SELECT * FROM akun");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi User</title>
    <link rel="stylesheet" href="../element/style.css">
</head>
<body>
    <?php require "../element/navbar_admin.php";?>
    <section class="creator-services-section">
        <h1 class="h1-tag">Informasi User</h1>
        <section class="search-section">
            <div class="search-bar">
                <input type="text" name="keyword" id="keyword" placeholder="Searching...">
            </div>
        </section>
        <div class="tag-content" id="user-table">
            <div class="backtoadmin">
                <a href="berandaatmin.php">Back</a>
            </div>
            <table border="2" class="creator_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        $rows = $result->fetch_all(MYSQLI_ASSOC);
                        $i = 1;
                        foreach($rows as $row) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>                        
                            <button>
                                <a href="disable_user.php?id=<?= $row['id'] ?>&disable=<?= $row['disable'] ?>">
                                    <?= $row['disable'] ? 'Aktifkan' : 'Nonaktifkan' ?>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <?php $i++; } 
                        } else {
                            echo "<p>No users found.</p>";
                        }
                        $conn->close();
                        ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
<script src="../element/script.js"></script>
</html>