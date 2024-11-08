<?php
    session_start();
    require "../koneksi.php";

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

    if (isset($_POST['submit'])) {
        $new_username = mysqli_real_escape_string($conn, $_POST['username']);
        $new_email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_description = mysqli_real_escape_string($conn, $_POST['description']);
        $tmp_name = $_FILES["profile"]["tmp_name"];
        $file_name = $_FILES["profile"]["name"];
        $file_size = $_FILES["profile"]["size"]; 

        $max_size = 2 * 1024 * 1024; 
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        $ekstensi = explode('.', $file_name);
        $ekstensi = strtolower(end($ekstensi));
        $ekstensi = "." . $ekstensi;

        $newFileName = $id . $ekstensi;

        

        if(!in_array(trim($ekstensi, '.'), $allowed_extensions)) {
            echo "
            <script>
                alert('Ekstensi file tidak diizinkan. Hanya jpg, jpeg, png yang diizinkan.');
                document.location.href = 'editprofil.php';
            </script>";
        } 
        elseif ($file_size > $max_size) {
            echo "
            <script>
                alert('Ukuran file terlalu besar! Maksimal 100MB.');
                document.location.href = 'editprofil.php';
            </script>";
        } else {
            if(move_uploaded_file($tmp_name, '../asset/profile_picture/' . $newFileName)) {
                $sql = "UPDATE akun SET username='$new_username', email='$new_email', deskripsi='$new_description', profile_picture='$newFileName' WHERE id = $id";
                $result = mysqli_query($conn, $sql);
        
                if($result){
                    echo "
                    <script>
                        alert('Berhasil Memperbarui Profile!');
                    </script>";
                    header("Location: userprofil.php");
                    exit();
                } else {
                    $error = mysqli_error($conn);
                    echo "
                    <script>
                        alert('Gagal Memperbarui Profile! Error: $error');
                        document.location.href = 'editprofil.php';
                    </script>";
                }
            } else {
                echo "
                <script>
                    alert('File Tidak Valid atau Gagal diunggah.');
                    document.location.href = 'editprofil.php';
                </script>";
            }
        }
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
    <header>
        <nav id="" class="navbar">
            <nav class="navbar-area">
                <div class="navbar-logo">
                    <a href="../utama/beranda.php">
                        <img src="../asset/LOGO.png" alt="TembokKertas">
                    </a>
                    <div class="navbar-list">
                        <a href="../utama/beranda.php">Beranda</a>
                        <a href="../utama/aboutUs.php">About Us</a>
                    </div>
                </div>
                <div class="navbar-upload">
                    <a href="../user/upload.php">Upload</a>
                    <div class="navbar-profile">
                        <a href="../user/userprofil.php"><img src='<?php echo $_SESSION['profile_picture']?>' alt='profile-picture' width='100px'></a>
                    </div>
                </div>
            </nav>
        </nav>
    </header>
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
                <a class="profile-edit-active" href="editprofil.php">
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
                <h1>Edit Profile Information</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="profile-pic-container">
                        <div class="profile-pic">
                            <img id="preview" src="<?php echo $profile_row['profile_picture']; ?>" alt="Preview" style="display: block;">
                            <div class="camera-icon" onclick="document.getElementById('profile').click()">
                                <input type="file" name="profile" id="profile" accept="image/*" style="display: none;" onchange="previewImage(event)" required>
                                <i class="fa-solid fa-camera fa-2xl" style="color: #ffff;"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-form-group">
                        <label for="username">Username&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil"></i></label>
                        <input id="username" name="username" type="text" placeholder="Type your username..." value="<?php echo $profile_row['username']; ?>" required>
                    </div>
                    <div class="profile-form-group">
                        <label for="email">Email&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil"></i></label>
                        <input id="email" name="email" type="email" placeholder="Type your email..." value="<?php echo $profile_row['email']; ?>" required>
                    </div>
                    <div class="profile-form-group-d">
                        <label for="Description">Description&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil"></i></label>
                        <textarea id="Description" name="description" placeholder="Type your description.."><?php echo $profile_row['deskripsi']; ?></textarea>
                    </div>
                    <input type="submit" class="done-button" name="submit" value="Done"></input>
                </form>
            </div>
        </div>
    </section>
    <script src="../element/script.js"></script>
</body>
</html>