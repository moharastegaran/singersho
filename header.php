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
    <ul class="list-group-flush">
        <li class="list-group-item <?php echo (strpos($current_url, 'index.php') !== false) ? 'active' : ''?>">
            <a href="index.php" data-ripple="">
                <!--                <img src="assets/img/icons/home.svg">-->
                صفحه اصلی
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'singing_test.php') !== false) ? 'active' : ''?>">
            <a href="singing_test.php" data-ripple="">
                <!--                <img src="assets/img/icons/computer.svg">-->
                تست خوانندگی
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'about.php') !== false) ? 'active' : ''?>">
            <a href="about.php" data-ripple="">
                <!--                <img src="assets/img/icons/info.svg">-->
                درباره ما
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'contact.php') !== false) ? 'active' : ''?>">
            <a href="contact.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                تماس باما
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'store.php') !== false) ? 'active' : ''?>">
            <a href="store.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                فروشگاه
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'artists.php') !== false) ? 'active' : ''?>">
            <a href="artists.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                هنرمندان
            </a>
        </li>
        <li class="list-group-item <?php echo (strpos($current_url, 'studios.php') !== false) ? 'active' : ''?>">
            <a href="studios.php" data-ripple="">
                <!--                <img src="assets/img/icons/phone-call.svg">-->
                استدیوها
            </a>
        </li>
        <?php if (isset($_SESSION['access_token'])) : ?>
            <li class="list-group-item <?php echo (strpos($current_url, 'profile.php') !== false) ? 'active' : ''?>">
                <a href="profile.php" class="text-muted" data-ripple="">
                    <!--                <img src="assets/img/icons/home.svg">-->
                    پروفایل
                </a>
            </li>
            <li class="list-group-item item-logout">
                <a href="logout.php" data-ripple="">
                    <!--                <img src="assets/img/icons/home.svg">-->
                    خروج
                </a>
            </li>
        <?php endif; ?>
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

        <a class="navbar-brand flex-lg-grow-1 text-center">
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