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
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php for ($i = 0; $i < count($cart_details['details']); $i++) : ?>
                                    <tr>
                                        <?php switch ($cart_details['details'][$i]['type']) :
                                            case 'package' : ?>
                                                <td>
                                                    <div class="cart__img">
                                                        <img src="<?php echo $cart_details['details'][$i]['image']; ?>"
                                                             alt="<?php echo $cart_details['details'][$i]['full_name']; ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="package.php?id=<?php echo $cart_details['details'][$i]['id']; ?>">
                                                        <?php echo $cart_details['details'][$i]['full_name']; ?></a>
                                                </td>
                                                <td><span class="cart__price">
                                                        <?php echo format_price($cart_details['details'][$i]['price']) . ' تومان' ?>
                                                    </span></td>
                                                <?php break; ?>
                                            <?php endswitch; ?>
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

                    <!-- promo -->
                    <form action="#" class="cart__promo sign__group sign__group-inline">
                        <input type="text" class="sign__input" placeholder="کد تخفیف">
                        <button type="button" class="sign__btn btn-purple">اعمال</button>
                    </form>
                    <!-- end promo -->


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
                            <button type="button" class="sign__btn">تکمیل</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end checkout -->
        </div>
    </div>
    </div>
<?php else: ?>
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <!-- cart -->
            <div class="thead">
                <h1 class="thead-main">سبد خرید</h1>
            </div>
            <div class="alert alert-lg alert-outline-danger mt-4 mw-100" style="margin-right: 0;">
                سبد خرید شما خالی است.
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php';
