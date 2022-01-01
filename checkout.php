<?php
include 'header.php';

$cart_details = array(); ?>

    <div class="container mx-auto cart__single">
    <nav aria-label="breadcrumbs">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="خانه">خانه</a></li>
            <li class="breadcrumb-item active" aria-current="page">تسویه حساب</li>
        </ul>
    </nav>
<?php if (isset($_SESSION['cart'])) :
    $cart_details = json_decode($_SESSION['cart'], true); ?>
    <div class="row mt-5 mb-5">
        <div class="col-12 col-lg-8">
            <!-- cart -->
            <div class="thead">
                <h1 class="thead-main">سبد خرید</h1>
            </div>
            <div class="cart">
                <div class="cart__table-wrap">
                    <div class="cart__table-scroll" data-scrollbar="true" tabindex="-1"
                         style="overflow: hidden; outline: none;">
                        <div class="scroll-content">
                            <table class="cart__table">
                                <thead>
                                <tr>
                                    <th>محصول</th>
                                    <th>عنوان</th>
                                    <th>قیمت</th>
                                    <th style="width: 25%">جزئیات</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php for ($i = 0; $i < count($cart_details['details']); $i++) :
                                    $cart_detail = $cart_details['details'][$i]; ?>
                                    <tr data-id="<?php echo $cart_detail['id']; ?>"
                                        data-type="<?php echo $cart_detail['type']; ?>">
                                        <td>
                                            <div class="cart__img">
                                                <img src="<?php echo $cart_detail['image']; ?>"
                                                     alt="<?php echo $cart_detail['full_name']; ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo (in_array($cart_detail['type'],['advisor','teammate']) ? 'artist' : $cart_detail['type']); ?>.php?id=<?php echo $cart_detail['type_id']; ?>">
                                                <?php echo $cart_detail['full_name']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="cart__price">
                                                        <?php echo format_price($cart_detail['price']) . ' تومان' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="cart__details">
                                                <?php $cart_desc = $cart_detail['details']; ?>
                                                <?php switch ($cart_detail['type']) :
                                                    case 'advisor'  : ?>
                                                        ساعت و زمان مشاوره
                                                        <?php echo $cart_desc['shamsi_date_1'] ?>
                                                        ساعت
                                                        <?php echo $cart_desc['time']['started_at'] ?>
                                                        تا
                                                        <?php echo $cart_desc['time']['ended_at'] ?>
                                                        <?php break; ?>
                                                    <?php endswitch; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="cart__delete" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path d="M13.41,12l6.3-6.29a1,1,0,1,0-1.42-1.42L12,10.59,5.71,4.29A1,1,0,0,0,4.29,5.71L10.59,12l-6.3,6.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l6.29,6.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="cart__info">
                    <div class="cart__total">
                        <p>جمع کل:</p>
                        <span><?php echo format_price($cart_details['final_cost']) . ' تومان' ?></span>
                    </div>


                    <form class="cart__form-discount sign__group sign__group-inline" method="get">
                        <input type="text" name="discount_code" class="sign__input" placeholder="کد تخفیف" autocomplete="off" required>
                        <button type="submit" class="sign__btn">اعمال</button>
                    </form>


                </div>
            </div>
            <!-- end cart -->
        </div>

        <div class="col-12 col-lg-4">
            <!-- checkout -->
            <div class="thead">
                <h1 class="thead-main">اطلاعات تسویه</h1>
            </div>
            <div class="cart">
                <div class="cart__table-wrap">
                    <form action="#" class="sign__form--cart">
                        <div class="sign__group">
                            <input type="text" name="name" placeholder="نام و نام خانوادگی" autocomplete="off">
                        </div>

                        <div class="sign__group">
                            <input type="text" name="email" placeholder="ایمیل" autocomplete="off">
                        </div>

                        <div class="sign__group">
                            <input dir="ltr" type="text" name="phone" placeholder="09*********"
                                   style="letter-spacing: 1px">
                        </div>
                        <div class="sign__group">
                            <p class="sign__text sign__text--small">
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                            </p>
                        </div>
                        <div class="sign__group">
                            <button type="button" class="sign__btn">
                                تکمیل و پرداخت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end checkout -->
        </div>
    </div>
    </div>
<?php else: ?>
    <div class="row my-md-5 my-sm-4 my-3">
        <div class="col-md-12">
            <div class="thead">
                <h1 class="thead-main">سبد خرید</h1>
            </div>
        </div>
        <div class="<?php echo (!isset($_SESSION['access_token'])) ? 'col-md-8' : 'col-md-12'; ?>">
            <div class="cart cart__empty">
                <div class="cart__table-wrap py-5">
                    <div class="col-lg-5 col-md-7 col-12 mx-auto">
                        <img src="assets/img/empty-cart.png" class="img-fluid pb-4">
                        <h6 class="cart__empty-title">سبد خرید شما خالی است!</h6>
                        <p class="cart__empty-text">می‌توانید برای مشاهده محصولات بیشتر به صفحات زیر بروید</p>
                        <ul class="redirect-links">
                            <li><a href="artists.php">هنرمندان</a></li>
                            <li><a href="store.php">فروشگاه</a></li>
                            <li><a href="studios.php">استدیوها</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!isset($_SESSION['access_token'])) : ?>
            <div class="col-md-4 my-md-0 my-3">
                <a href="login.php">
                    <div class="cart cart__empty">
                        <div class="cart__table-wrap text-right">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M18.9,0H5.1A5.055,5.055,0,0,0,0,5V8A1,1,0,0,0,2,8V5A3.054,3.054,0,0,1,5.1,2H18.9A3.054,3.054,0,0,1,22,5V19a3.054,3.054,0,0,1-3.1,3H5.1A3.054,3.054,0,0,1,2,19V16a1,1,0,0,0-2,0v3a5.055,5.055,0,0,0,5.1,5H18.9A5.055,5.055,0,0,0,24,19V5A5.055,5.055,0,0,0,18.9,0Z"/>
                                <path d="M3,12a1,1,0,0,0,1,1H4l13.188-.03-4.323,4.323a1,1,0,1,0,1.414,1.414l4.586-4.586a3,3,0,0,0,0-4.242L14.281,5.293a1,1,0,0,0-1.414,1.414l4.262,4.263L4,11A1,1,0,0,0,3,12Z"/>
                            </svg>
                            <h6 class="cart__empty-title">ورود به حساب کاربری</h6>
                            <p class="cart__empty-text">برای مشاهده محصولات سبد خرید خود وارد حساب کاربری‌تان شوید.</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php';
