<?php
  session_start();
  require "../koneksi.php" ;
  if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM akun WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc($result);
      if (password_verify($password, $user["password"])) {
        if ($user['disable'] == 0) {
          session_regenerate_id(true);
          $_SESSION['username'] = $user['username'];
          $_SESSION['id'] = $user['id']; 
          $_SESSION['login'] = true;
          if ($_POST['username'] == "admin") {
              $_SESSION["role"] = "admin";
              echo 
              "<script>
                  alert('Login Berhasil');
                  document.location.href = '../admin/berandaatmin.php'
              </script>";
              exit;
          } else {
              $_SESSION["role"] = "user";
              echo 
              "<script>
                  alert('Login Berhasil');
                  document.location.href = '../utama/beranda.php'
              </script>";
              exit;
          }
        } else {
          echo "<script>
                  alert('Akun Anda Dinonaktifkan');
                  document.location.href = 'login.php';
                </script>";
        }
      } else {
        echo "<script>
                alert('Password Salah');
                document.location.href = 'login.php';
              </script>";
      }
    } else {
      echo "<script>
        alert('Username atau Password Salah');
        document.location.href = 'login.php';
      </script>";
    }
  }
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-logres">
  <div class="wrapper-logres">
    <h1>Login</h1>
    <form action="" id="form" method="post">
      <div>
        <label for="username-input">
          <i class="fa-solid fa-user" style="color: #ffffff;"></i>
        </label>
        <input type="text" name="username" id="username-input" placeholder="Username" required>
      </div>
      <div>
        <label for="password-input">
            <i class="fa-solid fa-lock fa" style="color: #ffffff;"></i>
        </label>
        <input type="password" name="password" id="password-input" placeholder="Password" required>
      </div>
      <button type="submit" name="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Register</a></p>
  </div>
</body>
<script src="../element/script.js"></script>
</html>