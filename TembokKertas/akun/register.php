<?php
  require "../koneksi.php";
  if(isset($_POST["submit"])) {
    $email = $_POST['email'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST['cpassword'];

    if ($password === $cpassword) {
      $checkQuery = "SELECT * FROM akun WHERE username = '$username'";
      $checkResult = mysqli_query($conn, $checkQuery);

      $password = password_hash($password, PASSWORD_DEFAULT);

      if (mysqli_num_rows($checkResult) > 0){
        echo
        "<script>
          alert('Username sudah terdaftar');
          document.location.href = 'register.php';
        </script>";
      } else {
        $query = "INSERT INTO akun VALUES ('','$username','$password','','$email','default.jpg','0')";
        $result = mysqli_query($conn, $query);
        if ($result) {
          echo "
          <script>
            alert('Sign Up Berhasil');
            document.location.href = 'login.php';
          </script>";
        } else {
          echo "
          <script>
            alert('Sign Up Gagal');
            document.location.href = 'register.php';
          </script>";
        }
      }
    } else {
      echo "
      <script>
        alert('Password dan repeat password harus sama');
        document.location.href = 'register.php';
      </script>";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="bg-logres">
  <div class="wrapper-logres">
    <h1>Register</h1>
    <form action="" id="form" method="post" >
      <div>
        <label for="username-input">
          <i class="fa-solid fa-user" style="color: #ffffff;"></i>
        </label>
        <input type="text" name="username" id="username-input" placeholder="Username" required>
      </div>
      <div>
        <label for="email-input">
          <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
        </label>
        <input type="email" name="email" id="email-input" placeholder="Email" required>
      </div>
      <div>
        <label for="password">
            <i class="fa-solid fa-lock fa" style="color: #ffffff;"></i>        
        </label>
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>
      <div>
        <label for="cpassword">
            <i class="fa-solid fa-lock fa" style="color: #ffffff;"></i>
        </label>
        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
      </div>
      <button type="submit" name="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">login</a> </p>
  </div>
</body>
<script src="../element/script.js"></script>
</html>