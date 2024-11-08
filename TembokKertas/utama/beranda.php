<?php
	session_start();
	require '../koneksi.php';
	
	if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/berandaatmin.php");
            exit();
        }
    }

	$tag_sql = "SELECT * FROM tag_detail";
	$tag_result = $conn->query($tag_sql);

	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$profile_sql = "SELECT profile_picture FROM akun WHERE username = '$username'";
		$profile_result = $conn->query($profile_sql);

		if ($profile_result->num_rows > 0) {
			$profile_row = $profile_result->fetch_assoc();
			$_SESSION['profile_picture'] = '../asset/profile_picture/' . $profile_row['profile_picture'];
		} else {
			$_SESSION['profile_picture'] = '../asset/profile_picture/default.jpg';
		}
	}

	if (isset($_SESSION['id_user']) && isset($_GET['id'])) {
		$id_user = $_SESSION['id_user'];
		$id = $_GET['id'];
		$check_like_sql = "SELECT * FROM likekomen WHERE id_user = '$id_user' AND id_wallpaper = '$id'";
		$check_like_result = $conn->query($check_like_sql);
		if ($check_like_result->num_rows > 0) {
			$delete_like_sql = "DELETE FROM likekomen WHERE id_user = '$id_user' AND id_wallpaper = '$id'";
			$conn->query($delete_like_sql);
		} else {
			$insert_like_sql = "INSERT INTO likekomen VALUES ('', '$id_user', '$id')";
			$conn->query($insert_like_sql);
		}
	}
	
	if (isset($_POST['tag'])) {
		$selected_tag = $_POST['tag'];
		if ($selected_tag == '0') {
			$sql_wallpaper = "SELECT wallpaper.id AS id, wallpaper.path AS wallpaper, wallpaper.nama AS nama, akun.username AS user, akun.profile_picture AS picture FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id";
		} else {
			$sql_wallpaper = "SELECT wallpaper.id AS id, wallpaper.path AS wallpaper, wallpaper.nama AS nama, akun.username AS user, akun.profile_picture AS picture FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id JOIN tag ON wallpaper.id = tag.id_wallpaper JOIN tag_detail ON tag.id_tag_detail = tag_detail.id WHERE tag_detail.id = '$selected_tag'";
		}
	} else {
		$sql_wallpaper = "SELECT wallpaper.id AS id, wallpaper.path AS wallpaper, wallpaper.nama AS nama, akun.username AS user, akun.profile_picture AS picture FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id";
	}
	$wallpaper_result = $conn->query($sql_wallpaper);

	if (isset($_POST['search'])) {
		$search = $_POST['search'];
		$sql_wallpaper = "SELECT wallpaper.id AS id, wallpaper.path AS wallpaper, wallpaper.nama AS nama, akun.username AS user, akun.profile_picture AS picture FROM wallpaper JOIN akun ON wallpaper.id_user = akun.id WHERE wallpaper.nama LIKE '%$search%'";
		$wallpaper_result = $conn->query($sql_wallpaper);
	}

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
	<header>
		<nav id="navbar" class="navbar">
			<nav class="navbar-area">
				<div class="navbar-logo">
					<a href="beranda.php">
						<img src="../asset/LOGO.png" alt="TembokKertas">
					</a>
					<div class="navbar-list">
						<a href="beranda.php">Beranda</a>
						<a href="aboutUs.php">About Us</a>
					</div>
				</div>
				<?php if(basename($_SERVER['PHP_SELF']) != 'aboutUs.php' && 
						basename($_SERVER['PHP_SELF']) != 'upload.php' &&
						basename($_SERVER['PHP_SELF']) != 'wallpaper.php') :
				?>
					<div class="navbar-search">
						<form method="POST" action="beranda.php"><i class="fas fa-search"></i>
							<input type="text" name="search" placeholder="Searching" id="">
							<button type="submit"></button>
						</form>
					</div>
				<?php endif; ?>
				<?php if(isset($_SESSION['username'])):?>
					<div class="navbar-upload">
						<a href="../user/upload.php" class="tup">Upload</a>
						<div class="navbar-profile">
							<a href="../user/userprofil.php"><img src='<?php echo $_SESSION['profile_picture']?>' alt='profile-picture' width='100px'></a>
						</div>
					</div>
				<?php else: ?>
					<div class="nav-log">
						<a href="../akun/login.php">Login</a>
					</div>
				<?php endif; ?>
			</nav>
		</nav>
	</header>
	<section class="tagging">
		<form id="tagForm" method="POST" action="beranda.php">
			<iron-selector selected="0" attr-for-selected="id" class="tag-selector">
				<div id="0" class="tag" onclick="selectTag(0)">All</div>
				<?php 
					while($tag_row = $tag_result->fetch_assoc()) {
						echo '<div id="'.$tag_row['id'].'" class="tag tag-click" onclick="selectTag('.$tag_row['id'].')">'. $tag_row['jenis'] .'</div>';
					}
				?>
			</iron-selector>
			<input type="hidden" name="tag" id="selectedTag" value="0">
		</form>
	</section>
	<div class="columns">
		<?php
		if ($wallpaper_result->num_rows > 0) {
			$rows = $wallpaper_result->fetch_all(MYSQLI_ASSOC);
			$direktori = '../asset/profile_picture/';
			foreach($rows as $row) {
				echo '<figure>';
				echo '<img src="' . $row["wallpaper"] . '" alt="' . $row["nama"] . ' " class="display-wallpaper">';
				echo '<div class="overlay" onclick="location.href=\'wallpaper.php?id='. $row['id'] .'\';">';
				echo '<img src="' . $direktori . $row["picture"] .'" alt="' . $row["user"] . '" class="uploader-picture">';
				echo '<p>' . $row["user"] . '</p>'; 	
				echo '<div class="button">';
				echo '<a href="' . $row["wallpaper"] . '" download class="download-btn" title="Download"><i class="fa-solid fa-download fa-xl" style="color: #ffffff;"></i></a>';
				echo '</div>';
				echo '</div>';
				echo '</figure>';
			}
		} else {
			echo "<p>No wallpapers found.</p>";
		}
		$conn->close();
		?>
		<small>Wallpaper &copy; <a href="../utama/aboutUs.php">TembokKertas</a></small>
	</div> 
</body>
<script src="../element/script.js"></script>
</html>