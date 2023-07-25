<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sneaker Station</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="<?= url('public/images/Logo.png') ?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!---------------------------------Navbar Start---------------------------->
    <nav>
        <div class="navdata container">
            <a href="<?= url('') ?>"><img src="<?= url('public/images/Logo.png') ?>" alt="image not found" /></a>
            <div class="nav-items">
                <a href="index.php" class="<?= $title === 'index' ? 'active' : '' ?>">home</a>
                <a href="male.php" class="<?= $title === 'male' ? 'active' : '' ?>">male</a>
                <a href="women.php" class="<?= $title === 'women' ? 'active' : '' ?>">women</a>
                <a href="kids.php" class="<?= $title === 'kids' ? 'active' : '' ?>">kids</a>
                <a href="used.php" class="<?= $title === 'used' ? 'active' : '' ?>">Used</a>
                <a href="sellus.php" class="<?= $title === 'sellus' ? 'active' : '' ?>">sell us</a>
                <?php if (isset($_GET['search'])) { ?>
                    <i class="fa-solid fa-xmark" onclick="search();"></i>
                <?php } else { ?>
                    <i class="fa-solid fa-magnifying-glass" onclick="search();"></i>
                <?php } ?>
            </div>
            <?php
            if (isset($_SESSION['name']) && isset($_SESSION['email'])) { ?>
                <div class="user-details">
                    <a href="<?= url('cart.php') ?>"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>
                    <div class="dropdown">
                        <button onmouseover="showDropdown()" onmouseout="hideDropdown()" class="user-button">
                            <i class="fas fa-user" style="color: #ffffff;"></i>
                        </button>
                        <div id="dropdown-content" class="dropdown-content" onmouseover="showDropdown()" onmouseout="hideDropdown()">
                            <a href="<?= url('history.php') ?>">History</a>
                            <a href="<?= url('logout.php') ?>">Logout</a>
                        </div>
                    </div>
                </div>
            <?php } else {
            ?>
                <button class="login-register"><a href="login.php">Login/Register</a></button>
            <?php } ?>
            <button id="bars" onclick="navResponsive();">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- responsive nav -->
            <div id="burgernav">
                <div class="items">
                    <div class="cross" onclick="navResponsive();">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <form action="searchResults.php">
                            <div class="burgersearch">
                            <input type="search" id="search" placeholder="Search Here" />
                        </div>
                        </form>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="male.php">Male</a></li>
                    <li><a href="women.php">women</a></li>
                    <li><a href="kids.php">kids</a></li>
                    <li><a href="sellus.php">sell us</a></li>
                </div>
                <?php if (!isset($_SESSION['name']) && !isset($_SESSION['email'])) { ?>
                    <div class="login_btn">
                        <a href="#"><img src="./public/images/burgernav_img.svg" alt="Image not found" /></a>
                        <button><a href="login.php">Login/Signup</a></button>
                    </div>
            </div>
        <?php }  ?>

        </div>
    </nav>
    <!-- for search box -->
    <form action="searchResults.php">
        <div class="searchBox" style="<?php echo isset($_GET['search']) && !empty($_GET['search']) ? 'display: flex;' : 'display: none;'; ?>">
            <div class="container">
                <input type="search" name="search" placeholder="Search Here" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
            </div>
        </div>
    </form>
    <!---------------------------------Navbar End---------------------------->