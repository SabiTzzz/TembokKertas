<?php
    session_start();
    require '../koneksi.php';

    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/berandaatmin.php");
            exit();
        }
    }

    if (isset($_SESSION['username'])) {
		$id = $_SESSION['id'];
		$profile_sql = "SELECT * FROM akun WHERE id = '$id'";
		$profile_result = $conn->query($profile_sql);

		if ($profile_result->num_rows > 0) {
			$profile_row = $profile_result->fetch_assoc();
			$profile_row['profile_picture'] = '../asset/profile_picture/' . $profile_row['profile_picture'];
		} else {
			$profile_row['profile_picture'] = '../asset/profile_picture/default.jpg';
		}
	} else {
        header("Location: ../akun/login.php");
        exit();
    }

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
                    <a class="profile-info-active" href="userprofil.php">
                        <i class="fas fa-fw fa-user"></i>Personal Info
                    </a>
                </li>
            <li>
                <a class="profile-edit" href="editprofil.php">
                    <i class="fas fa-fw fa-pen-to-square"></i>Profile Edit
                </a>
            </li>
            <li>
                <a class="profile-uploaded" href="upprofil.php">
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
                <h1>Profile Information</h1>   
                <div class="profile-pic-container">
                    <div class="profile-pic">
                        <img src="<?php echo $profile_row['profile_picture'] ?>" alt="">
                    </div>
                </div>
                <div class="profile-form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" placeholder="Type your username..." value="<?php echo $profile_row['username'] ?>" readonly/>
                </div>
                <div class="profile-form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Type your email..." value="<?php echo $profile_row['email']; ?>" readonly/>
                </div>  
                <div class="profile-form-group-d">
                    <label for="Description">Description</label>
                    <textarea id="Description" placeholder="Your description..." readonly><?php echo $profile_row['deskripsi']; ?></textarea>
                </div>  
            </div>
        </div>
    </section>
</body>
</html>