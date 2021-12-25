<?php
include 'config/config.php';
$current_url = $_SERVER['REQUEST_URI'];
$page_name = substr($current_url, strrpos($current_url, '/') + 1);
if (isset($_SESSION['access_token'])){
    $cart = callAPI('GET',RAW_API.'cart',false,true);
    $cart = json_decode($cart,true);
    if (!$cart['error'] && count($cart['cart']['details'])){
        $_SESSION['cart'] = json_encode([
            'final_cost' => $cart['cart']['final_cost'],
            'details' => $cart['cart']['details'],
        ]);
    }else{
        unset($_SESSION['cart']);
        if (count($cart['messages'])){
            die($cart['messages'][0]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>خواننده شو</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="fa"/>

    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome/all.min.css">
    <link rel="stylesheet" href="assets/css/snackbar.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <?php if (strpos($page_name, 'profile') === false) : ?>
        <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">

        <link rel="stylesheet" type="text/css" href="assets/css/perfect-scrollbar.css">
        <link rel="stylesheet" href="assets/css/select2.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">


    <?php else : ?>
        <link rel="stylesheet" href="assets/css/persian-datepicker.css">
        <link rel="stylesheet" type="text/css" href="assets/css/file-upload-with-preview.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    <?php endif; ?>
    <!--    <link rel="stylesheet" href="assets/css/switches.min.css">-->
</head>

<body>

<!-- deleteModal -->
<div id="deleteModal-container">
    <div id="deleteModal">
        <h4>حذف آیتم</h4>
        <p>این عمل قابل برگشت نخواهد بود</p>
        <a class="ok">حذف</a>
        <a class="cancel">بیخیال</a>
    </div>
</div>
<!-- END deleteModal -->

<nav id="mm-menu">
    <ul class="list-group-flush">
        <?php if (!isset($_SESSION['access_token'])) : ?>
            <li class="list-group-item">
                <a href="profile.php" data-ripple="">
                    <!--                <img src="assets/img/icons/home.svg">-->
                    پروفایل
                </a>
            </li>
            <li class="list-group-item">
                <a href="logout.php" data-ripple="">
                    <!--                <img src="assets/img/icons/home.svg">-->
                    خروج
                </a>
            </li>
        <?php endif; ?>
        <li class="list-group-item">
            <a href="index.php" data-ripple="">
                <!--                <img src="assets/img/icons/home.svg">-->
                صفحه اصلی
            </a>
        </li>
        <li class="list-group-item">
            <a href="singing_test.php" data-ripple="">
                <!--                <img src="assets/img/icons/computer.svg">-->
                تست خوانندگی
            </a>
        </li>
        <li class="list-group-item">
            <a href="about.php" data-ripple="">
                <!--                <img src="assets/img/icons/info.svg">-->
                درباره ما
            </a>
        </li>
        <li class="list-group-item">
            <a href="contact.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                تماس باما
            </a>
        </li>
        <li class="list-group-item">
            <a href="store.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                فروشگاه
            </a>
        </li>
        <li class="list-group-item">
            <a href="artists.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                هنرمندان
            </a>
        </li>
        <li class="list-group-item">
            <a href="studios.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                استدیوها
            </a>
        </li>
    </ul>
</nav>

<header class="<?php if (strpos($current_url, 'index.php') !== false) { ?> fixed-top <?php } else { ?> confirm-sticky <?php } ?>">
    <div class="responsive-header">
        <a href="#mm-menu">
            منو
            <!--            <img src="assets/img/icons/align-right.svg">-->
        </a>
        <a href="index.php" title="">
            <img src="assets/img/logo.png" alt="" height="30">
        </a>
    </div>

    <nav id="topbar" class="navbar navbar-expand-md justify-content-between">

        <ul class="navbar-nav align-items-center">
            <li class="dropdown--menu dropdown">
                <img src="assets/img/icons/menu-burger.svg" class="dropdown-toggle" data-toggle="dropdown">
                <!--                    <span class="bar-1"></span>-->
                <!--                    <span class="bar-2"></span>-->
                <!--                    <span class="bar-3"></span>-->
                <ul class="dropped dropdown-menu">
                    <li class="dropdown-item"><a href="store.php"><img src="assets/img/icons/shop.svg"> فروشگاه</a></li>
                    <li class="dropdown-item"><a href="artists.php"><img src="assets/img/icons/users.svg"> هنرمندان</a>
                    </li>
                    <li class="dropdown-item"><a href="studios.php"><img src="assets/img/icons/music.svg"> استدیوها</a>
                    </li>
                    <?php if (!isset($_SESSION['access_token'])) : ?>
                        <li class="dropdown-item"><a href="login.php"><img src="assets/img/icons/sign-in-alt.svg"> ورود</a>
                        </li>
                    <?php else : ?>
                        <li class="dropdown-item"><a href="profile.php"><img src="assets/img/icons/sign-in-alt.svg">
                                پروفایل</a></li>
                        <li class="dropdown-item"><a href="logout.php"><img src="assets/img/icons/logout.svg"> خروج</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="nav-item <?php if (strpos($page_name, 'index') !== false) {
                echo 'active';
            } ?>"><a href="index.php" class="nav-link hvr-underline-from-center">صفحه اصلی</a></li>
            <li class="nav-item <?php if (strpos($page_name, 'singing_test') !== false) {
                echo 'active';
            } ?>"><a href="singing_test.php" class="nav-link hvr-underline-from-center ">تست خوانندگی</a></li>
        </ul>

        <a class="navbar-brand flex-lg-grow-1 text-center">
            <img src="assets/img/logo.png">
        </a>

        <ul class="navbar-nav">
            <li class="nav-item <?php if (strpos($page_name, 'about') !== false) {
                echo 'active';
            } ?>"><a href="about.php" class="nav-link hvr-underline-from-center">درباره ما</a></li>
            <li class="nav-item <?php if (strpos($page_name, 'contact') !== false) {
                echo 'active';
            } ?>"><a href="contact.php" class="nav-link hvr-underline-from-center">تماس با ما</a></li>
        </ul>
    </nav>
</header>

<div id="mm-0">

    <main>