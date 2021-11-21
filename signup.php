<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>صفحه ورود | مجموعه قالب سویش</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/font-awesome/all.min.css" />
    <link rel="stylesheet" href="assets/css/auth.min.css" />
    <link rel="stylesheet" href="assets/css/auth.rtl.min.css" />
</head>
<body>

<div id="preloader-wrapper">
    <div id="loading-layer">
        <div class="loading">
            <div class="rect-one"></div>
            <div class="rect-two"></div>
            <div class="rect-three"></div>
            <div class="rect-four"></div>
            <div class="rect-five"></div>
        </div>
    </div>
</div>

<div class="d-flex flex-column justify-content-center swish-wrapper text-center" id="auth-page">
    <div class="container-fluid form-container register box-rounded">
        <div class="row">

            <div class="col-md-6 d-flex overlay-box shadow">
                <div class="overlay-background rounded"></div>
                <div class="overlay-content mx-auto">
                    <div class="row no-gutters my-auto">
                        <div class="col logo py-4 mx-auto">
                            <a class="logo-link" href="index.php">
                                <img class="logo-image" alt="Logo" src="assets/img/logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="row no-gutters my-auto">
                        <div class="col message-box px-3 mx-auto">
                            <h2 class="text-white mb-4">خوش آمدید!</h2>
                            <p class="mb-4">با آدرس ایمیل و رمز ورود خود وارد شوید تا با ما در ارتباط باشید.</p>
                            <a class="btn bg-white text-neutral btn-lg shadow-lg mb-4 box-rounded" href="login.php">ورود</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 form-box bg-white rounded shadow my-auto">
                <div class="d-flex flex-column sign-in-container h-100">
                    <div class="align-items-center sign-in mx-auto my-auto px-4 py-5">

                        <form class="sign-in-form h-100">
                            <h2 class="text-header text-decoration-underline">حساب ایجاد کنید</h2>

                            <div class="form-group mb-3 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text box-rounded-left"><i class="fas fa-user-circle"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg box-rounded-right" type="text" required="" placeholder="نام">
                                    <div class="input-group-append"></div>
                                </div>
                            </div>
                            <div class="form-group mb-3 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text box-rounded-left"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg box-rounded-right" type="email" placeholder="ایمیل" required="">
                                    <div class="input-group-append"></div>
                                </div>
                            </div>
                            <div class="form-group my-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text box-rounded-left"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control form-control-lg box-rounded-right" type="password" placeholder="رمز عبور" required="">
                                    <div class="input-group-append"></div>
                                </div>
                            </div>

                            <button class="btn btn-main shadow-sm btn-block box-rounded" type="submit">ثبت نام</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!--<script src="assets/js/color-switcher.min.js"></script>-->
<!--<script src="assets/js/preloader.min.js"></script>-->
<!--<script src="assets/js/rocket-loader.min.js" defer=""></script>-->
</body>
</html>