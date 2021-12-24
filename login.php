<?php
session_start();
$is_register = isset($_GET['action']) && $_GET['action'] === 'register';
$is_forgot = isset($_GET['action']) && $_GET['action'] === 'forgot';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = array();
    include 'config/config.php';

    if ($is_register) {
    } elseif ($is_forgot) {
    } else {
        $old = null;
        $get_login = callAPI('POST', RAW_API . 'login', $_POST);
        $action_result = json_decode($get_login, true);
        if (!$action_result['error']) {
            $_SESSION['access_token'] = $action_result['access_token'];
            header("Location:profile.php");
            exit();
        } else {
            $old = $_POST;
        }
    }

    if ($action_result['error']) $errors = $action_result['messages'];
}

?>

<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>فرم ورود به حساب کاربری</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/*" href="assets/img/favicon.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome/fontawesome.min.css">

    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>

<section class="fxt-template-layout24">
    <!-- Video Area Start Here -->

    <!-- Video Area Start Here -->
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-3">
                <div class="fxt-header">
                    <a href="index.php" class="fxt-logo"><img src="assets/img/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="fxt-content">
                    <div class="thead">
                        <h1 class="thead-main">
                            <?php
                            if ($is_register)
                                echo 'ثبت نام';
                            elseif ($is_forgot)
                                echo 'فراموشی رمز';
                            else
                                echo 'ورود';
                            ?>
                        </h1>
                        <p class="thead-description">
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        </p>
                    </div>
                    <?php if (isset($errors) && count($errors)) : ?>
                        <div class="input-error">
                            <?php for ($i = 0; $i < count($errors); $i++) : ?>
                                <?php echo $errors[$i] . '<br>'; ?>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                    <div class="fxt-form">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="sign__group">
                                <input type="text" id="mobile" name="mobile"
                                       placeholder="شماره تماس" value="<?php if (isset($old)) {
                                    echo $old['mobile'];
                                } ?>" required="required" autocomplete="off">
                            </div>
                            <?php if ($is_register) : ?>
                                <div class="sign__group">
                                    <input id="first_name" type="text" name="first_name" placeholder="نام">
                                </div>
                                <div class="sign__group">
                                    <input id="last_name" type="text" name="last_name" placeholder="نام خانوادگی">
                                </div>
                                <div class="sign__group">
                                    <input id="password" type="password" name="password" placeholder="رمز عبور"
                                           required="required">
                                    <i class="toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419C21.72,6.893,18.192,2.655,12,2.655S2.28,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162C2.28,17.107,5.808,21.345,12,21.345s9.72-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419Zm-1.705,4.115C20.234,15.7,17.219,19.345,12,19.345S3.766,15.7,2.434,13.534a2.918,2.918,0,0,1,0-3.068C3.766,8.3,6.781,4.655,12,4.655s8.234,3.641,9.566,5.811A2.918,2.918,0,0,1,21.566,13.534Z"/>
                                            <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z"/>
                                        </svg>
                                        <svg class="d-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419A15.866,15.866,0,0,0,19.9,5.51l2.8-2.8a1,1,0,0,0-1.414-1.414L18.241,4.345A12.054,12.054,0,0,0,12,2.655C5.809,2.655,2.281,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162A15.866,15.866,0,0,0,4.1,18.49l-2.8,2.8a1,1,0,1,0,1.414,1.414l3.052-3.052A12.054,12.054,0,0,0,12,21.345c6.191,0,9.719-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419ZM2.433,13.534a2.918,2.918,0,0,1,0-3.068C3.767,8.3,6.782,4.655,12,4.655A10.1,10.1,0,0,1,16.766,5.82L14.753,7.833a4.992,4.992,0,0,0-6.92,6.92l-2.31,2.31A13.723,13.723,0,0,1,2.433,13.534ZM15,12a3,3,0,0,1-3,3,2.951,2.951,0,0,1-1.285-.3L14.7,10.715A2.951,2.951,0,0,1,15,12ZM9,12a3,3,0,0,1,3-3,2.951,2.951,0,0,1,1.285.3L9.3,13.285A2.951,2.951,0,0,1,9,12Zm12.567,1.534C20.233,15.7,17.218,19.345,12,19.345A10.1,10.1,0,0,1,7.234,18.18l2.013-2.013a4.992,4.992,0,0,0,6.92-6.92l2.31-2.31a13.723,13.723,0,0,1,3.09,3.529A2.918,2.918,0,0,1,21.567,13.534Z"/>
                                        </svg>
                                    </i>
                                </div>
                                <div class="sign__group">
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                           required="required" placeholder="تکرار رمز عبور">
                                    <i class="toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419C21.72,6.893,18.192,2.655,12,2.655S2.28,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162C2.28,17.107,5.808,21.345,12,21.345s9.72-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419Zm-1.705,4.115C20.234,15.7,17.219,19.345,12,19.345S3.766,15.7,2.434,13.534a2.918,2.918,0,0,1,0-3.068C3.766,8.3,6.781,4.655,12,4.655s8.234,3.641,9.566,5.811A2.918,2.918,0,0,1,21.566,13.534Z"/>
                                            <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z"/>
                                        </svg>
                                        <svg class="d-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419A15.866,15.866,0,0,0,19.9,5.51l2.8-2.8a1,1,0,0,0-1.414-1.414L18.241,4.345A12.054,12.054,0,0,0,12,2.655C5.809,2.655,2.281,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162A15.866,15.866,0,0,0,4.1,18.49l-2.8,2.8a1,1,0,1,0,1.414,1.414l3.052-3.052A12.054,12.054,0,0,0,12,21.345c6.191,0,9.719-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419ZM2.433,13.534a2.918,2.918,0,0,1,0-3.068C3.767,8.3,6.782,4.655,12,4.655A10.1,10.1,0,0,1,16.766,5.82L14.753,7.833a4.992,4.992,0,0,0-6.92,6.92l-2.31,2.31A13.723,13.723,0,0,1,2.433,13.534ZM15,12a3,3,0,0,1-3,3,2.951,2.951,0,0,1-1.285-.3L14.7,10.715A2.951,2.951,0,0,1,15,12ZM9,12a3,3,0,0,1,3-3,2.951,2.951,0,0,1,1.285.3L9.3,13.285A2.951,2.951,0,0,1,9,12Zm12.567,1.534C20.233,15.7,17.218,19.345,12,19.345A10.1,10.1,0,0,1,7.234,18.18l2.013-2.013a4.992,4.992,0,0,0,6.92-6.92l2.31-2.31a13.723,13.723,0,0,1,3.09,3.529A2.918,2.918,0,0,1,21.567,13.534Z"/>
                                        </svg>
                                    </i>
                                </div>
                                <div class="sign__group">
                                    <button type="submit" class="btn-purple w-100">ثبت نام</button>
                                </div>
                            <?php elseif ($is_forgot) : ?>
                                <div class="sign__group">
                                    <button type="submit" class="btn-purple w-100">ارسال کد</button>
                                </div>
                            <?php else : ?>
                                <div class="sign__group">
                                    <input id="password" type="password" name="password" placeholder="********"
                                           required="required">
                                    <i class="toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419C21.72,6.893,18.192,2.655,12,2.655S2.28,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162C2.28,17.107,5.808,21.345,12,21.345s9.72-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419Zm-1.705,4.115C20.234,15.7,17.219,19.345,12,19.345S3.766,15.7,2.434,13.534a2.918,2.918,0,0,1,0-3.068C3.766,8.3,6.781,4.655,12,4.655s8.234,3.641,9.566,5.811A2.918,2.918,0,0,1,21.566,13.534Z"/>
                                            <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z"/>
                                        </svg>
                                        <svg class="d-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.271,9.419A15.866,15.866,0,0,0,19.9,5.51l2.8-2.8a1,1,0,0,0-1.414-1.414L18.241,4.345A12.054,12.054,0,0,0,12,2.655C5.809,2.655,2.281,6.893.729,9.419a4.908,4.908,0,0,0,0,5.162A15.866,15.866,0,0,0,4.1,18.49l-2.8,2.8a1,1,0,1,0,1.414,1.414l3.052-3.052A12.054,12.054,0,0,0,12,21.345c6.191,0,9.719-4.238,11.271-6.764A4.908,4.908,0,0,0,23.271,9.419ZM2.433,13.534a2.918,2.918,0,0,1,0-3.068C3.767,8.3,6.782,4.655,12,4.655A10.1,10.1,0,0,1,16.766,5.82L14.753,7.833a4.992,4.992,0,0,0-6.92,6.92l-2.31,2.31A13.723,13.723,0,0,1,2.433,13.534ZM15,12a3,3,0,0,1-3,3,2.951,2.951,0,0,1-1.285-.3L14.7,10.715A2.951,2.951,0,0,1,15,12ZM9,12a3,3,0,0,1,3-3,2.951,2.951,0,0,1,1.285.3L9.3,13.285A2.951,2.951,0,0,1,9,12Zm12.567,1.534C20.233,15.7,17.218,19.345,12,19.345A10.1,10.1,0,0,1,7.234,18.18l2.013-2.013a4.992,4.992,0,0,0,6.92-6.92l2.31-2.31a13.723,13.723,0,0,1,3.09,3.529A2.918,2.918,0,0,1,21.567,13.534Z"/>
                                        </svg>
                                    </i>
                                </div>
                                <div class="sign__group">
                                    <div class="fxt-checkbox-area">
                                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=forgot"
                                           class="switcher-text">فراموشی
                                            رمزعبور</a>
                                        <button type="submit" class="btn-purple">ورود</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="fxt-footer">
                        <?php if ($is_register || $is_forgot) : ?>
                            <p>قبلا ثبت نام کرده‌اید؟<a href="<?php echo $_SERVER['PHP_SELF'] ?>"
                                                        class="switcher-text2 inline-text">ورود</a></p>
                        <?php else : ?>
                            <p>هنوز اکانت ندارید؟<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=register"
                                                    class="switcher-text2 inline-text">ثبت نام</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<!--<script src="assets/js/imagesloaded.pkgd.min.js"></script>-->
<script src="assets/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toggle-password').on('click', function (e) {
            const input = $(this).prev();
            $(this).find('svg').toggleClass('d-none');
            input.attr('type', input.attr('type') === 'text' ? 'password' : 'text')
        });
    });
</script>

</body>

</html>