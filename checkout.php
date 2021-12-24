<?php
include 'header.php';

$cart_details = array();
if (isset($_SESSION['cart'])) {
    $cart_details = json_decode($_SESSION['cart'], true);
}

?>

<div class="cart__single container mx-auto">
    <nav aria-label="breadcrumbs">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="خانه">خانه</a></li>
            <li class="breadcrumb-item active" aria-current="page">تسویه حساب</li>
        </ul>
    </nav>
    <div class="thead">
        <h1 class="thead-main">سبد خرید</h1>
    </div>
    <div dir="rtl" class="row">
        <div class="col-12 col-lg-8">
            <!-- cart -->
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
                                                <td><a href="package.php?id=<?php echo $cart_details['details'][$i]['id']; ?>">
                                                        <?php echo $cart_details['details'][$i]['full_name']; ?></a></td>
                                                <td><span class="cart__price">
                                                        <?php echo format_price($cart_details['details'][$i]['price']).' تومان'?>
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
                        <span><?php echo format_price($cart_details['final_cost']). 'تومان' ?></span>
                    </div>

                    <!-- promo -->
                    <form action="#" class="cart__promo">
                        <input type="text" class="sign__input" placeholder="کد تخفیف">
                        <button type="button" class="sign__btn sign__btn--blue">اعمال</button>
                    </form>
                    <!-- end promo -->


                </div>
            </div>
            <!-- end cart -->
        </div>

        <div class="col-12 col-lg-4">
            <!-- checkout -->
            <form action="#" class="sign__form sign__form--cart">
                <h3 class="sign__title">تسویه حساب</h3>
                <div class="sign__group">
                    <input type="text" name="name" placeholder="نام و نام خانوادگی">
                </div>

                <div class="sign__group">
                    <input type="text" name="email" placeholder="ایمیل">
                </div>

                <div class="sign__group">
                    <input dir="ltr" type="text" name="phone" placeholder="09*********">
                </div>
                <div class="sign__group sign__group--row">
                    <span class="sign__text sign__text--small text-justify">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</span>
                </div>
                <button type="button" class="sign__btn">تکمیل</button>
            </form>
            <!-- end checkout -->
        </div>
    </div>
</div>

<?php include 'footer.php';
