<?php
include 'config/config.php';
$current_url = $_SERVER['REQUEST_URI'];
$page_name = substr($current_url, strrpos($current_url, '/') + 1);
$cart_counter = 0;
if (isset($_SESSION['access_token'])) {
    $cart = callAPI('GET', RAW_API . 'cart', false, true);
//    echo $cart;
//    die()
    $cart = json_decode($cart, true);
    if (!$cart['error'] && count($cart['cart']['details'])) {
        $_SESSION['cart'] = json_encode([
            'final_cost' => $cart['cart']['final_cost'],
            'details' => $cart['cart']['details'],
        ]);
        $cart_counter = count($cart['cart']['details']);
    } else {
        unset($_SESSION['cart']);
        if (count($cart['messages'])) {
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
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <?php if (strpos($page_name, 'profile') === false) : ?>
        <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">

        <link rel="stylesheet" type="text/css" href="assets/css/perfect-scrollbar.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <?php else : ?>
        <link rel="stylesheet" href="assets/css/persian-datepicker.css">
        <link rel="stylesheet" type="text/css" href="assets/css/file-upload-with-preview.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

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
    <img src="assets/img/logo.png" class="mm-logo">
    <ul class="list-group-flush">
        <li class="list-group-item <?php echo (strpos($current_url, 'index.php') !== false) ? 'active' : ''?>">
            <a href="index.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z"/></svg>
                صفحه اصلی
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'singing_test.php') !== false) ? 'active' : ''?>">
            <a href="singing_test.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,1H5A5.006,5.006,0,0,0,0,6v8a5.006,5.006,0,0,0,5,5h6v2H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2H13V19h6a5.006,5.006,0,0,0,5-5V6A5.006,5.006,0,0,0,19,1ZM5,3H19a3,3,0,0,1,3,3v7H2V6A3,3,0,0,1,5,3ZM19,17H5a3,3,0,0,1-2.816-2H21.816A3,3,0,0,1,19,17Z"/></svg>
                تست خوانندگی
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'about.php') !== false) ? 'active' : ''?>">
            <a href="about.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z"/><path d="M12,10H11a1,1,0,0,0,0,2h1v6a1,1,0,0,0,2,0V12A2,2,0,0,0,12,10Z"/><circle cx="12" cy="6.5" r="1.5"/></svg>
                درباره ما
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'contact.php') !== false) ? 'active' : ''?>">
            <a href="contact.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13,1a1,1,0,0,1,1-1A10.011,10.011,0,0,1,24,10a1,1,0,0,1-2,0,8.009,8.009,0,0,0-8-8A1,1,0,0,1,13,1Zm1,5a4,4,0,0,1,4,4,1,1,0,0,0,2,0,6.006,6.006,0,0,0-6-6,1,1,0,0,0,0,2Zm9.093,10.739a3.1,3.1,0,0,1,0,4.378l-.91,1.049c-8.19,7.841-28.12-12.084-20.4-20.3l1.15-1A3.081,3.081,0,0,1,7.26.906c.031.031,1.884,2.438,1.884,2.438a3.1,3.1,0,0,1-.007,4.282L7.979,9.082a12.781,12.781,0,0,0,6.931,6.945l1.465-1.165a3.1,3.1,0,0,1,4.281-.006S23.062,16.708,23.093,16.739Zm-1.376,1.454s-2.393-1.841-2.424-1.872a1.1,1.1,0,0,0-1.549,0c-.027.028-2.044,1.635-2.044,1.635a1,1,0,0,1-.979.152A15.009,15.009,0,0,1,5.9,9.3a1,1,0,0,1,.145-1S7.652,6.282,7.679,6.256a1.1,1.1,0,0,0,0-1.549c-.031-.03-1.872-2.425-1.872-2.425a1.1,1.1,0,0,0-1.51.039l-1.15,1C-2.495,10.105,14.776,26.418,20.721,20.8l.911-1.05A1.121,1.121,0,0,0,21.717,18.193Z"/></svg>
                تماس باما
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'store.php') !== false) ? 'active' : ''?>">
            <a href="store.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21,6H18A6,6,0,0,0,6,6H3A3,3,0,0,0,0,9V19a5.006,5.006,0,0,0,5,5H19a5.006,5.006,0,0,0,5-5V9A3,3,0,0,0,21,6ZM12,2a4,4,0,0,1,4,4H8A4,4,0,0,1,12,2ZM22,19a3,3,0,0,1-3,3H5a3,3,0,0,1-3-3V9A1,1,0,0,1,3,8H6v2a1,1,0,0,0,2,0V8h8v2a1,1,0,0,0,2,0V8h3a1,1,0,0,1,1,1Z"/></svg>
                فروشگاه
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'artists.php') !== false) ? 'active' : ''?>">
            <a href="artists.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="_01_align_center" data-name="01 align center"><path d="M9,12a6,6,0,1,1,6-6A6.006,6.006,0,0,1,9,12ZM9,2a4,4,0,1,0,4,4A4,4,0,0,0,9,2Z"/><path d="M18,24H16V18.957A2.961,2.961,0,0,0,13.043,16H4.957A2.961,2.961,0,0,0,2,18.957V24H0V18.957A4.963,4.963,0,0,1,4.957,14h8.086A4.963,4.963,0,0,1,18,18.957Z"/><path d="M22,7.875a2.107,2.107,0,0,0-2,2.2,2.107,2.107,0,0,0-2-2.2,2.107,2.107,0,0,0-2,2.2c0,2.3,4,5.133,4,5.133s4-2.829,4-5.133A2.107,2.107,0,0,0,22,7.875Z"/></g></svg>
                هنرمندان
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'studios.php') !== false) ? 'active' : ''?>">
            <a href="studios.php" data-ripple="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,1H13A5.006,5.006,0,0,0,8,6v8.026A4.948,4.948,0,0,0,5,13a5,5,0,1,0,5,5V6a3,3,0,0,1,3-3h6a3,3,0,0,1,3,3v8.026A4.948,4.948,0,0,0,19,13a5,5,0,1,0,5,5V6A5.006,5.006,0,0,0,19,1ZM5,21a3,3,0,1,1,3-3A3,3,0,0,1,5,21Zm14,0a3,3,0,1,1,3-3A3,3,0,0,1,19,21Z"/></svg>
                استدیوها
            </a>
        </li>
        <?php if (isset($_SESSION['access_token'])) : ?>
            <li class="list-group-item <?php echo (strpos($current_url, 'profile.php') !== false) ? 'active' : ''?>">
                <a href="profile.php" class="text-muted" data-ripple="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.9,0H5.1A5.055,5.055,0,0,0,0,5V8A1,1,0,0,0,2,8V5A3.054,3.054,0,0,1,5.1,2H18.9A3.054,3.054,0,0,1,22,5V19a3.054,3.054,0,0,1-3.1,3H5.1A3.054,3.054,0,0,1,2,19V16a1,1,0,0,0-2,0v3a5.055,5.055,0,0,0,5.1,5H18.9A5.055,5.055,0,0,0,24,19V5A5.055,5.055,0,0,0,18.9,0Z"/><path d="M3,12a1,1,0,0,0,1,1H4l13.188-.03-4.323,4.323a1,1,0,1,0,1.414,1.414l4.586-4.586a3,3,0,0,0,0-4.242L14.281,5.293a1,1,0,0,0-1.414,1.414l4.262,4.263L4,11A1,1,0,0,0,3,12Z"/></svg>
                    پروفایل
                </a>
            </li>
            <li class="list-group-item item-logout">
                <a href="logout.php" data-ripple="">
                    <svg fill="#eb5757" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <defs><style>.cls-1{fill:none;}</style></defs>
                        <path d="M6,30H18a2.0023,2.0023,0,0,0,2-2V25H18v3H6V4H18V7h2V4a2.0023,2.0023,0,0,0-2-2H6A2.0023,2.0023,0,0,0,4,4V28A2.0023,2.0023,0,0,0,6,30Z"/><polygon points="20.586 20.586 24.172 17 10 17 10 15 24.172 15 20.586 11.414 22 10 28 16 22 22 20.586 20.586"/>
                        <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="17" height="17"/>
                    </svg>
                    خروج
                </a>
            </li>
        <?php else : ?>
            <li class="list-group-item <?php echo (strpos($current_url, 'login.php') !== false) ? 'active' : ''?>">
                <a href="login.php" class="text-muted" data-ripple="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.9,0H5.1A5.055,5.055,0,0,0,0,5V8A1,1,0,0,0,2,8V5A3.054,3.054,0,0,1,5.1,2H18.9A3.054,3.054,0,0,1,22,5V19a3.054,3.054,0,0,1-3.1,3H5.1A3.054,3.054,0,0,1,2,19V16a1,1,0,0,0-2,0v3a5.055,5.055,0,0,0,5.1,5H18.9A5.055,5.055,0,0,0,24,19V5A5.055,5.055,0,0,0,18.9,0Z"/><path d="M3,12a1,1,0,0,0,1,1H4l13.188-.03-4.323,4.323a1,1,0,1,0,1.414,1.414l4.586-4.586a3,3,0,0,0,0-4.242L14.281,5.293a1,1,0,0,0-1.414,1.414l4.262,4.263L4,11A1,1,0,0,0,3,12Z"/></svg>
                    ورود
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<header class="<?php echo (strpos($current_url, 'index.php') !== false) ? 'fixed-top' : 'confirm-sticky' ?>">
    <div class="responsive-header">
        <a href="#mm-menu" data-ripple="">منو</a>
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
                    <li class="dropdown-item <?php echo (strpos($current_url, 'store.php') !== false) ? 'active' : ''?>">
                        <a href="store.php"><img src="assets/img/icons/shop.svg"> فروشگاه</a></li>
                    <li class="dropdown-item <?php echo (strpos($current_url, 'artists.php') !== false) ? 'active' : ''?>">
                        <a href="artists.php"><img src="assets/img/icons/users.svg"> هنرمندان</a>
                    </li>
                    <li class="dropdown-item <?php echo (strpos($current_url, 'studios.php') !== false) ? 'active' : ''?>">
                        <a href="studios.php"><img src="assets/img/icons/music.svg"> استدیوها</a>
                    </li>
                    <?php if (!isset($_SESSION['access_token'])) : ?>
                        <li class="dropdown-item <?php echo (strpos($current_url, 'login.php') !== false) ? 'active' : ''?>">
                            <a href="login.php"><img src="assets/img/icons/sign-in-alt.svg"> ورود</a>
                        </li>
                    <?php else : ?>
                        <li class="dropdown-item <?php echo (strpos($current_url, 'profile.php') !== false) ? 'active' : ''?>">
                            <a href="profile.php"><img src="assets/img/icons/sign-in-alt.svg">
                                پروفایل</a></li>
                        <li class="dropdown-item item-logout"><a href="logout.php"><img src="assets/img/icons/logout-danger.svg"> خروج</a>
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

        <a class="navbar-brand flex-lg-grow-1 text-center" href="index.php">
            <img src="assets/img/logo.png">
        </a>

        <ul class="navbar-nav align-items-center">
            <li class="nav-item <?php if (strpos($page_name, 'about') !== false) {
                echo 'active';
            } ?>"><a href="about.php" class="nav-link hvr-underline-from-center">درباره ما</a></li>
            <li class="nav-item <?php if (strpos($page_name, 'contact') !== false) {
                echo 'active';
            } ?>"><a href="contact.php" class="nav-link hvr-underline-from-center">تماس با ما</a></li>
            <li class="nav-item">
                <a href="checkout.php" class="btn__cart">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354A2.994,2.994,0,0,0,22.713,4.077ZM21.4,6.178l-.786,4.354A3,3,0,0,1,17.657,13H5.419L4.478,5H20.41A1,1,0,0,1,21.4,6.178Z"/>
                        <circle cx="7" cy="22" r="2"/>
                        <circle cx="17" cy="22" r="2"/>
                    </svg>
<!--                    --><?php //if (isset($cart_counter) && $cart_counter > 0) : ?>
<!--                        <span class="cart__counter">--><?php //echo $cart_counter; ?><!--</span>-->
<!--                    --><?php //endif; ?>
                </a>
            </li>
        </ul>
    </nav>
</header>

<div id="mm-0">

    <main>