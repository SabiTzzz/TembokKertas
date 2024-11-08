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

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    if ($keyword) {
        $query = "SELECT * FROM akun WHERE username LIKE '%$keyword%' OR email LIKE '%$keyword%'";
        $result = mysqli_query($conn, $query);
    } else {
        $result = mysqli_query($conn, "SELECT * FROM akun");
    }
?>
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
            <?php if ($result && $result->num_rows > 0) {
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
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                $conn->close();
                ?>
        </tbody>
    </table>
</div>