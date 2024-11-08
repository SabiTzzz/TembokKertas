<?php 
    session_start();
    require "../koneksi.php";

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

    if(isset($_POST["submit"])){
        $wallpapername = $_POST["nama"];
        $description = $_POST["description"];
        $tags = $_POST["tags"];
        $tmp_name = $_FILES["wallpaper"]["tmp_name"];
        $file_name = $_FILES["wallpaper"]["name"];
        $file_size = $_FILES["wallpaper"]["size"];

        $max_size = 100 * 1024 * 1024 * 1024;

        list($width, $height) = getimagesize($tmp_name);
        $file_res = $width . 'x' . $height;
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        $ekstensi = explode('.', $file_name);
        $ekstensi = strtolower(end($ekstensi));
        $ekstensi = "." . $ekstensi;

        $newFileName = date('Y-m-d H.i.s') . $ekstensi;

        if(!in_array(ltrim($ekstensi, '.'), $allowed_extensions)) {
            echo "
            <script>
                alert('Ekstensi file tidak diizinkan. Hanya jpg, jpeg, png yang diizinkan.');
                document.location.href = 'upload.php';
            </script>";
        } 
        elseif ($file_size > $max_size) {
            echo "
            <script>
                alert('Ukuran file terlalu besar! Maksimal 100MB.');
                document.location.href = 'uploadWallpaper.php';
            </script>";
        } else {
            if(move_uploaded_file($tmp_name, '../asset/wallpaper/' . $newFileName)) {
                $sql = "INSERT INTO wallpaper VALUES ('','$id', '$wallpapername', '$description', '', '$file_res', '../asset/wallpaper/$newFileName')";
                $result = mysqli_query($conn, $sql);
                $wallpaper_id = mysqli_insert_id($conn);
        
                if($result){
                    foreach($tags as $tag) {
                        $sql_tag = "INSERT INTO tag (id_wallpaper, id_tag_detail) VALUES ('$wallpaper_id', '$tag')";
                        mysqli_query($conn, $sql_tag);
                    }
                    echo "
                    <script>
                        alert('Berhasil Mengunggah Wallpaper!');
                        document.location.href = 'upprofil.php';
                    </script>";
                } else {
                    $error = mysqli_error($conn);
                    echo "
                    <script>
                        alert('Gagal Mengunggah Wallpaper! Error: $error');
                        document.location.href = 'upload.php';
                    </script>";
                }
            } else {
                echo "
                <script>
                    alert('File Tidak Valid atau Gagal diunggah.');
                    document.location.href = 'upload.php';
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
    <title>TembokKertas | Upload Wallpaper</title>
    <link rel="stylesheet" href="../element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <?php include '../element/navbar.php'; ?>
    <section class="upload-section">
        <h1 class="form-header">Upload Wallpaper</h1>
        <hr>
        <form action="" method="post" enctype="multipart/form-data" class="form-upload" onsubmit="return confirm('Upload Wallpaper?')">
            <div class="form-upload-left">
                <div class="preview-up" onclick="uploadImage()">
                    <img id="preview" src="../asset/upload.png" alt="Preview">
                </div>
                <br><hr><br>
                <div class="button-upload-image">
                    <label for="wallpaper">Upload Wallpaper</label>
                    <input type="file" name="wallpaper" id="wallpaper" required onchange="previewImage(event)">
                </div>
            </div>
            <div class="form-upload-right">
                <div class="ur-form-group">
                    <label for="nama">Nama Wallpaper</label><br>
                    <input type="text" name="nama" id="nama" required><br>
                </div>
                <div class="ur-form-group-d">
                    <label for="description">Description</label><br>
                    <textarea name="description" id="description" required></textarea><br>
                </div>
                <label for="tags">Tags</label><br><br>
                <div class="tags-area">
                    <?php
                        $sql_tags = "SELECT * FROM tag_detail";
                        $result_tags = mysqli_query($conn, $sql_tags);
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($result_tags)) {
                            $class = '';
                            if ($count >= 6) {
                                $class = 'hidden-tag';
                            } else {
                                $class = '';
                            }
                            echo '<label class="tag-item ' . $class . '">
                                    <input type="checkbox" name="tags[]" value="' . $row['id'] . '"> ' . $row['jenis'] . '
                                  </label>';
                            $count++;
                        }
                    ?>
                </div>
                <div class="button-up">
                    <span><button id="toggle-tags" type="button" onclick="toggleTags()">Show More</button></span>
                    <button class="upload-button" type="submit" name="submit">Upload</button>
                </div>
            </div>
            <br>
        </form>
    </section>
    <?php require '../element/footer.php'; ?>
    <script src="../element/script.js"></script>
</body>
</html>