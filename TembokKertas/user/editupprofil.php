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
        $id = $_GET['id'];
        $wallpaper_sql = "SELECT * FROM wallpaper WHERE id = '$id'";
		$wallpaper_result = $conn->query($wallpaper_sql);
        $wallpaper_row = $wallpaper_result->fetch_assoc();
    } else {
        header("Location: ../akun/login.php");
        exit();
    }

    if(isset($_POST["submit"])){
        $wallpapername = $_POST["nama"];
        $description = $_POST["description"];
        $tags = $_POST["tags"];
        $wallpaper_update = mysqli_query($conn, "UPDATE wallpaper SET nama='$wallpapername', deskripsi='$description' WHERE id = $id");

        if($wallpaper_update){
            $old_tag = mysqli_query($conn, "DELETE FROM tag WHERE id_wallpaper = $id");
            foreach($tags as $tag) {
                $new_tag = mysqli_query($conn, "INSERT INTO tag VALUES ('', '$id', '$tag')");
            }
            echo "
            <script>
                alert('Berhasil Mengubah Wallpaper!');
                document.location.href = 'upprofil.php';
            </script>";
        } else {
            $error = mysqli_error($conn);
            echo "
            <script>
                alert('Gagal Mengubah Wallpaper! Error: $error');
                document.location.href = 'upload.php';
            </script>";
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
                    <img id="preview" src="<?= $wallpaper_row["path"] ?>" alt="Preview">
                </div>
                <br><hr><br>
                <div class="button-upload-image">
                    <label for="wallpaper">Upload Wallpaper</label>
                    <input type="file" name="wallpaper" id="wallpaper" readonly/>
                </div>
            </div>
            <div class="form-upload-right">
                <div class="ur-form-group">
                    <label for="nama">Nama Wallpaper</label><br>
                    <input type="text" name="nama" id="nama" value="<?= $wallpaper_row["nama"] ?>" required><br>
                </div>
                <div class="ur-form-group-d">
                    <label for="description">Description</label><br>
                    <textarea name="description" id="description"><?= $wallpaper_row["deskripsi"] ?></textarea><br>
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
                    <button class="upload-button" type="submit" name="submit">Changes</button>
                </div>
            </div>
            <br>
        </form>
    </section>
    <?php require '../element/footer.php'; ?>  
</body>
<script src="../element/script.js"></script>
</html>