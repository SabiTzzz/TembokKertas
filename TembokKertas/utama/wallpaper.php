<?php
	session_start();
	require '../koneksi.php';

	if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/berandaatmin.php");
            exit();
        }
    }

	$id = $_GET['id'];
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$id_user = $_SESSION['id'];
	} else {
        header("Location: ../akun/login.php");
        exit();
    }

	$profile_sql = "SELECT * FROM akun WHERE username = '$username'";
	$profile_result = $conn->query($profile_sql);

	if ($profile_result->num_rows > 0) {
		$profile_row = $profile_result->fetch_assoc();
		$_SESSION['profile_picture'] = '../asset/profile_picture/' . $profile_row['profile_picture'];
	} else {
		$_SESSION['profile_picture'] = '../asset/profile_picture/default.jpg';
	}

	$wallpaper_sql = "SELECT wallpaper.path AS wallpaper, wallpaper.nama AS nama, wallpaper.deskripsi AS deskripsi, wallpaper.size AS resolusi, wallpaper.disukai AS suka, akun.username AS user, akun.profile_picture AS picture, GROUP_CONCAT(tag_detail.jenis SEPARATOR ', ') as tags FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id JOIN tag ON wallpaper.id = tag.id_wallpaper JOIN tag_detail ON tag.id_tag_detail = tag_detail.id WHERE wallpaper.id = $id GROUP BY wallpaper.id";
	$wallpaper_result = $conn->query($wallpaper_sql);
	$wallpaper_row = $wallpaper_result->fetch_assoc();
	$direktori = '../asset/profile_picture/';

	$comment_sql = "SELECT komentar.id AS id, komentar.komen AS komen, komentar.jumlahlike AS suka, akun.username AS user, akun.profile_picture AS picture FROM komentar JOIN akun ON komentar.id_akun = akun.id WHERE komentar.id_wallpaper = $id";
	$comment_result = $conn->query($comment_sql);
	

	if (isset($_POST['submit'])) {
        $description = $_POST["comment"];
    
		$sql = "INSERT INTO komentar VALUES ('','$id_user', '$id', '$description', '')";
		$result = mysqli_query($conn, $sql);

		if($result){
			echo "
			<script>
				alert('Berhasil Mengirim Komentar!');
			</script>";
			header('Location: wallpaper.php?id=' . $id);
        	exit();
		} else {
			$error = mysqli_error($conn);
			echo "
			<script>
				alert('Gagal engirim Komentar! Error: $error');
			</script>";
			header('Location: wallpaper.php?id=' . $id);
        	exit();
		}
        
    }
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TembokKertas</title>
    <link rel="stylesheet" href="../element/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
	<?php include '../element/navbar.php'; ?>
	<section class="main-container-wp">
		<div class="container-wp">
			<img src="<?= $wallpaper_row["wallpaper"] ?>" alt="Wallpaper" class="wallpaper-image">
			<div class="details-wp">
				<h2><?= $wallpaper_row["nama"] ?></h2>
				<p><?= $wallpaper_row["deskripsi"] ?></p>
				<p>Tag: <span><?= $wallpaper_row['tags'] ?></span></p>
				<p>Size: <span><?= $wallpaper_row["resolusi"] ?></span></p>
				<br>
				<div class="details-action">
					<div class="details-profile">
						<p>Posted by</p>
						<div>
							<img src="<?= $direktori . $wallpaper_row['picture'] ?>" alt="Profile Picture" class="uploader-picture">
							<p><strong><?= $wallpaper_row["user"] ?></strong></p>
						</div>
					</div>
					<div class="details-button">
						<a href="<?= $wallpaper_row["wallpaper"] ?>" download="<?= $wallpaper_row["nama"] ?>.jpg" class="download-btn" title="Download">
							<i class="fa-solid fa-download fa-xl" style="color: #ffffff;"></i>
						</a>
					</div>
				</div>
			</div>
			<hr>
			<div class="comments">
				<h3>Komentar</h3>
				<div id="comment-list" class="comment-list">
					<?php
					if ($comment_result->num_rows > 0) {
						while ($comment_row = $comment_result->fetch_assoc()) {
							echo '<div class="comment">';
							echo '<img src="' . $direktori . $comment_row["picture"] .'" alt="' . $comment_row["user"] . '" class="uploader-picture">';
							echo '<p><strong>' . $comment_row["user"] . '</strong> ' . $comment_row["komen"] . '</p>';
							echo '</div><br>';
						}
					} else {
						echo '<p>No comments yet.</p>';
					}
					?>
				</div>
				<form action="" method="post">
					<div class="comment-box">
						<img src="<?= $direktori . $profile_row['profile_picture'] ?>" alt="Profile Picture">
						<textarea name="comment" id="comment" placeholder="Type your comment here..." required></textarea>
						<button class="send-btn" type="submit" name="submit"><i class="fa-regular fa-paper-plane fa-xl"></i></button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<?php include '../element/footer.php'; ?>
</body>
<script src="../element/script.js"></script>
</html>