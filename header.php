<?php
$current_url=$_SERVER['REQUEST_URI'];
$page_name = substr($current_url,strrpos($current_url,'/')+1);

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
    <link rel="stylesheet" type="text/css" href="assets/css/switches.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome/all.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>

<nav id="mm-menu">
    <ul class="list-group-flush">
        <li class="list-group-item">
            <a href="index.php" data-ripple="">
<!--                <img src="assets/img/icons/home.svg">-->
                صفحه اصلی
            </a>
        </li>
        <li class="list-group-item">
            <a href="index.php" data-ripple="">
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

<header class="<?php if (strpos($current_url,'index.php')!==false){ ?> fixed-top <?php }else{ ?> confirm-sticky <?php } ?>">
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
                    <li class="dropdown-item"><a href="artists.php"><img src="assets/img/icons/users.svg"> هنرمندان</a></li>
                    <li class="dropdown-item"><a href="studios.php"><img src="assets/img/icons/music.svg"> استدیوها</a></li>
                    <li class="dropdown-item"><a href="login1.php"><img src="assets/img/icons/sign-in-alt.svg"> ورود</a></li>
                </ul>
            </li>
            <li class="nav-item <?php if(strpos($page_name,'index')!==false){ echo 'active'; }?>"><a href="index.php" class="nav-link hvr-underline-from-center">صفحه اصلی</a></li>
            <li class="nav-item <?php if(strpos($page_name,'test')!==false){ echo 'active'; }?>"><a href="#" class="nav-link hvr-underline-from-center ">تست خوانندگی</a></li>
        </ul>

        <a class="navbar-brand flex-lg-grow-1 text-center">
            <img src="assets/img/logo.png">
        </a>

        <ul class="navbar-nav">
            <li class="nav-item <?php if(strpos($page_name,'about')!==false){ echo 'active'; }?>"><a href="about.php" class="nav-link hvr-underline-from-center">درباره ما</a></li>
            <li class="nav-item <?php if(strpos($page_name,'contact')!==false){ echo 'active'; }?>"><a href="contact.php" class="nav-link hvr-underline-from-center">تماس با ما</a></li>
        </ul>
    </nav>
</header>

<div id="mm-0">

    <main>