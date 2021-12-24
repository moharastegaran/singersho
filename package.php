<?php

include 'header.php';
if (isset($_GET['id'])) {
    $get_package = callAPI('GET', RAW_API . 'package/' . $_GET['id'] . '/detail', false);
    $get_package = json_decode($get_package, true);
    if (!$get_package['error']) {
        $package = $get_package['package'];
    }
}
?>

    <div class="container mx-auto package__single">
    <nav aria-label="breadcrumbs">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="خانه">خانه</a></li>
            <li class="breadcrumb-item"><a href="store.php" title="پکیج‌ها">پکیج‌ها</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $package['name'] ?></li>
        </ul>
    </nav>
    <div class="row">
    <div class="col-md-4">
        <h1 class="package__name"><?php echo $package['name'] ?></h1>
        <img src=" <?php echo !empty($package['image']) ? $package['image'] : 'assets/img/studio-placeholder.png' ?>"
             class="img-fluid package__image" style="border-radius: 12px">
    </div>
    <div class="col-md-4 d-flex flex-column justify-content-end align-items-start">
        <p class="package__description">
            <?php echo $package['description'] ?>
        </p>
        <ul class="package__social_links">
            <li><a href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                        <path d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"/>
                    </svg>
                </a></li>
            <li><a href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <path d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z"/>
                    </svg>
                </a></li>
            <li><a href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <path d="M12,27V15H8v-4h4V8.852C12,4.785,13.981,3,17.361,3c1.619,0,2.475,0.12,2.88,0.175V7h-2.305C16.501,7,16,7.757,16,9.291V11 h4.205l-0.571,4H16v12H12z"/>
                    </svg>
                </a></li>
            <li><a href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <path d="M28,6.937c-0.957,0.425-1.985,0.711-3.064,0.84c1.102-0.66,1.947-1.705,2.345-2.951c-1.03,0.611-2.172,1.055-3.388,1.295 c-0.973-1.037-2.359-1.685-3.893-1.685c-2.946,0-5.334,2.389-5.334,5.334c0,0.418,0.048,0.826,0.138,1.215 c-4.433-0.222-8.363-2.346-10.995-5.574C3.351,6.199,3.088,7.115,3.088,8.094c0,1.85,0.941,3.483,2.372,4.439 c-0.874-0.028-1.697-0.268-2.416-0.667c0,0.023,0,0.044,0,0.067c0,2.585,1.838,4.741,4.279,5.23 c-0.447,0.122-0.919,0.187-1.406,0.187c-0.343,0-0.678-0.034-1.003-0.095c0.679,2.119,2.649,3.662,4.983,3.705 c-1.825,1.431-4.125,2.284-6.625,2.284c-0.43,0-0.855-0.025-1.273-0.075c2.361,1.513,5.164,2.396,8.177,2.396 c9.812,0,15.176-8.128,15.176-15.177c0-0.231-0.005-0.461-0.015-0.69C26.38,8.945,27.285,8.006,28,6.937z"/>
                    </svg>
                </a></li>
        </ul>
    </div>
    <div class="col-md-4 d-flex flex-column justify-content-end align-items-start">
        <div class="card w-100 bg-dark px-3 py-4">
            <!--                    <div class="card-body">-->
            <h5 class="card-title mb-4">جزئیات محصول</h5>
            <?php if (count($package['members'])) : ?>
                <div class="row mb-3">
                    <div class="col-md-6 package__txt">تعداد اعضا</div>
                    <div class="col-md-6">
                                <span class="package__members-count package__txt">
                                    <strong><?php echo count($package['members']); ?></strong> نفر
                                </span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row mb-3">
                <div class="col-md-6 package__txt">زمان آماده‌سازی</div>
                <div class="col-md-6">
                            <span class="package__delivery-time package__txt">
                                <strong><?php echo $package['delivery_time']; ?></strong> روز
                            </span>
                </div>
            </div>
            <?php if ($package['po_number'] > 0): ?>
                <div class="row mb-3">
                    <div class="col-md-6 package__txt">تعداد فروش</div>
                    <div class="col-md-6">
                                <span class="package__po-number package__txt">
                                    <strong><?php echo $package['po_number']; ?></strong> بار
                                </span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row mb-3">
                <div class="col-md-6 package__txt">قیمت</div>
                <div class="col-md-6">
                            <span class="package__price package__txt" data-price="<?php echo $package['price']; ?>">
                                <strong><?php echo format_price($package['price']); ?></strong> تومان
                            </span>
                </div>
            </div>
            <?php
            $in_cart = false;
            if (isset($_SESSION['cart'])) {
                $cart_details = json_decode($_SESSION['cart'], true);
                $cart_details = $cart_details['details'];
                if (count($cart_details)) {
                    foreach ($cart_details as $index => $detail) {
                        if (strtolower($detail['type']) === 'package' && $detail['id'] === $package['id']) {
                            $in_cart = true;
                            break;
                        }
                    }
                }

            } ?>
            <p class="package__in-cart <?php echo !$in_cart ? 'd-none' : '';?>">
                مورد انتخابی در سبد خرید موجود است
                <br>
                <a href="javascript:void(0);" class="btn__remove-package"
                   data-id="<?php echo $package['id'] ?>">برداشتن از سبد خرید</a>
            </p>

            <a href="javascript:void(0);" class="btn__buy-package <?php echo $in_cart ? 'd-none' : '';?>"
               data-id="<?php echo $package['id'] ?>"> افزودن به سبد خرید</a>

            <!--                    </div>-->
        </div>
    </div>
<?php if (count($package['members'])) : ?>
    <div class="row col-12 mt-5">
        <div class="thead">
            <h2 class="thead-main">پدیدآورندگان</h2>
        </div>
        <?php for ($i = 0; $i < count($package['members']); $i++): ?>
            <?php $artist = $package['members'][$i]; ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php include 'views/cards/artist.php'; ?>
            </div>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php
include 'footer.php';


