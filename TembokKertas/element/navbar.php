<header>
    <nav id="navbar" class="navbar">
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
            <?php if(basename($_SERVER['PHP_SELF']) != 'aboutUs.php' && 
					 basename($_SERVER['PHP_SELF']) != 'upload.php' &&
					 basename($_SERVER['PHP_SELF']) != 'wallpaper.php' &&
                     basename($_SERVER['PHP_SELF']) != 'userprofil.php' &&
                     basename($_SERVER['PHP_SELF']) != 'favprofil.php' &&
                     basename($_SERVER['PHP_SELF']) != 'upprofil.php'):
			?>
                <div class="navbar-search">
                    <i class="fas fa-search"></i>
                    <input type="search" name="search" placeholder="Searching" id="">
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