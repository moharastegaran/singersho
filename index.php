<?php
include 'config/config.php';
include 'header.php';

$get_data = callAPI('GET',RAW_API.'artists',array('rpp'=>6));
$response = json_decode($get_data, true);
$artists = $response['artists']['data'];

$get_data = callAPI('GET',RAW_API.'packages',array('rpp'=>4));
$response = json_decode($get_data, true);
$packages = $response['packages']['data'];
?>

    <section class="main-heading-top">
        <img src="assets/img/header-bg.png">
        <div class="position-relative text-center" style="z-index: 3">
            <h1 class="scale-up-center">یک کلیک تا خوانندگی</h1>
            <a href="#" class="btn-singing-test hvr-grow-rotate slide-top" data-ripple="">خواننده شو</a>
        </div>
    </section>

    <section class="section-artists">
        <h2>هنرمندان</h2>

        <div class="position-relative">
            <div class="owl-carousel" id="artists-carousel">
                <?php for($i=0;$i<count($artists);$i++) : ?>
                    <?php $artist = $artists[$i]; ?>
                    <?php include 'views/cards/artist.php' ?>
                <?php endfor; ?>
            </div>
            <a href="javascript:void(0)" class="main__nav--prev" data-nav="#artists-carousel" type="button">
                <img src="assets/img/arrow-left.png">
            </a>
            <a href="javascript:void(0)" class="main__nav--next" data-nav="#artists-carousel" type="button">
                <img src="assets/img/arrow-right.png">
            </a>
        </div>
        <a href="artists.php" class="artists__link-to-all hvr-icon-pulse">
            مشاهده همه
            <i class="fas fa-chevron-left hvr-icon"></i>
        </a>
    </section>

    <section class="section-packages w-100">
        <h2>پکیج ها</h2>
        <div class="row px-md-4 p-0 align-items-center mx-auto">
            <div class="row col-lg-6 mb-lg-2 mb-md-5 mb-sm-5 mx-auto">
                <?php for ($i=0;$i<count($packages);$i++) : ?>
                    <?php $package = $packages[$i]; ?>
                    <div class="col-sm-6">
                        <?php include 'views/cards/package.php' ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="col-lg-6 col-md-10 col-11 mx-auto">
                <p class="text__about-packages">
                    ورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                    و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                    کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و
                    آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.
                </p>
                <a href="store.php" class="btn__goto-shop hvr-grow-rotate" data-ripple="">فروشگاه</a>
            </div>
        </div>

        <div class="features-container">
            <div class="d-flex flex-wrap flex-sm-row flex-column justify-content-between align-items-start">
                <div class="feature-box feature-search">
                    <div class="feature-head">
                        <img src="assets/img/ic_magnifier.png">
                        <h3>بگرد</h3>
                    </div>
                    <p class="feature-content">
                        از بین همه اینایی که هست میتونی خوبشو پیدا کنی
                    </p>
                </div>
                <div class="feature-box feature-counsel">
                    <div class="feature-head">
                        <img src="assets/img/ic_counseling.png">
                        <h3>مشورت کن</h3>
                    </div>
                    <p class="feature-content">
                        از بین همه اینایی که هست میتونی خوبشو پیدا کنی
                    </p>
                </div>
                <div class="feature-box feature-whole">
                    <div class="feature-head">
                        <img src="assets/img/ic_whole.png">
                        <h3>صفر تا صد</h3>
                    </div>
                    <p class="feature-content">
                        از بین همه اینایی که هست میتونی خوبشو پیدا کنی
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-studios">

        <div class="col-lg-6 col-md-10 col-sm-10 col-11 mx-auto text-right">
            <p class="text__about-studios">
                ورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و
                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.
            </p>
            <a href="studios.php" class="btn__goto-studios hvr-grow-rotate" data-ripple="">استدیوها</a>
        </div>
        <div class="col-lg-6 col-md-10 col-sm-10 col-11 mx-auto">
            <img src="assets/img/abut-singersho.png" class="img__about-studios">
        </div>
    </section>

<?php
include "footer.php";