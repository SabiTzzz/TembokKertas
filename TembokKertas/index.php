<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TembokKertas</title>
    <link rel="stylesheet" href="element/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <header>
        <nav id="navbar" class="navbar">
            <nav class="navbar-area">
                <div class="navbar-logo">
                    <a href="utama/beranda.php">
                        <img src="asset/LOGO.png" alt="TembokKertas">
                    </a>
                    <div class="navbar-list">
                        <a href="utama/beranda.php">Beranda</a>
                        <a href="utama/aboutUs.php">About Us</a>
                    </div>
                </div>
                <div class="nav-log">
                    <a href="akun/login.php">Login</a>
                </div>
            </nav>
        </nav>
    </header>
    <section class="judul">
        <h1>TembokKertas</h1>
        <div class="subjudul">
            <p>A discovery engine for</p>
            <p>WALLPAPER</p>
        </div>
        <div class="link-beranda">
            <a href="utama/beranda.php">Get Started</a>
        </div>
    </section>
    <section class="slider-container">
        <div class="gambar-slider">
            <div class="slider">
                <img src="asset/wallpaper/angkasa.jpg" alt="">
                <img src="asset/wallpaper/mobil.jpg" alt="">
                <img src="asset/wallpaper/k.jpg" alt="">
                <img src="asset/wallpaper/angkasa.jpg" alt="">
            </div>
        </div>
        <div class="cover"></div>
    </section>
    <?php include 'element/footer.php'; ?>  
</body>
<script src="element/script.js"></script>
</html>