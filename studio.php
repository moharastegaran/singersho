<?php

include 'header.php';

//$studio_id = 0;
$studio = null;
if (isset($_GET['id'])) {
    $get_studio = callAPI('GET', RAW_API . 'studio/' . $_GET['id'] . '/detail', false);
    $get_studio = json_decode($get_studio, true);
    if (!$get_studio['error'])
        $studio = $get_studio['studio'];
    else
        header('Location:index.php');

    $suggestions = callAPI('GET', RAW_API . 'studios', [
        'cityIds' => $studio['geographical_information']['city_id'],
        'min_max' => '0_' . ($studio['price'] + 500000),
        'rpp' => 6
    ]);
    $suggestions = json_decode($suggestions, true);
    $suggestions = $suggestions['studios']['data'];
    for ($j = 0; $j < count($suggestions); $j++) {
        if ($suggestions[$j]['id'] === $studio['id'])
            unset($suggestions[$j]);
    }
}

?>

    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="shape-top-right">
        <path d="M39.7,-23.1C47.3,-9.9,46.2,8.1,38.2,19.6C30.2,31.1,15.1,36.1,-4.5,38.8C-24.2,41.4,-48.3,41.6,-59,28.6C-69.6,15.6,-66.7,-10.6,-54.6,-26.5C-42.5,-42.4,-21.2,-48,-2.6,-46.5C16.1,-45,32.2,-36.4,39.7,-23.1Z"
              transform="translate(100 100)"/>
    </svg>

    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="shape-top-left">
        <path d="M24.1,-31.9C31.9,-27.4,39.6,-21.4,44.2,-13C48.9,-4.6,50.6,6.2,50.1,18.9C49.6,31.6,46.9,46.2,38.2,48C29.4,49.8,14.7,38.8,0.4,38.2C-13.9,37.6,-27.8,47.5,-34.3,45C-40.9,42.5,-40.1,27.6,-44.5,14.4C-48.9,1.2,-58.4,-10.4,-56.1,-18.4C-53.8,-26.4,-39.7,-30.8,-28.4,-34.2C-17.1,-37.5,-8.5,-39.8,-0.2,-39.5C8.1,-39.3,16.2,-36.4,24.1,-31.9Z"
              transform="translate(100 100)"/>
    </svg>

    <!--    <svg xmlns="http://www.w3.org/2000/svg" class="shape-bottom" viewBox="0 0 1440 320"><path d="M0,128L60,122.7C120,117,240,107,360,85.3C480,64,600,32,720,58.7C840,85,960,171,1080,192C1200,213,1320,171,1380,149.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>-->


    <div class="container mx-auto studio__single">
        <nav aria-label="breadcrumbs">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" title="خانه">خانه</a></li>
                <li class="breadcrumb-item"><a href="studios.php" title="استدیوها">استدیوها</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $studio['name']; ?></li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-lg-8 col-md-8 px-md-5">
                <div class="position-relative text-center">
                    <?php $pictures = $studio['pictures']; ?>
                    <?php if (count($pictures)): ?>
                        <div class="owl-carousel studio__carousel">
                            <?php for ($i = 0; $i < count($pictures); $i++) : ?>
                                <div class="item"
                                     style="background-image: url(<?php echo $pictures[$i]['path']; ?>)"></div>
                            <?php endfor; ?>
                        </div>
                        <a href="javascript:void(0)" class="main__nav--prev" data-nav="#artists-carousel" type="button">
                            <img src="assets/img/arrow-left.png">
                        </a>
                        <a href="javascript:void(0)" class="main__nav--next" data-nav="#artists-carousel" type="button">
                            <img src="assets/img/arrow-right.png">
                        </a>
                    <?php else: ?>
                        <img src="assets/img/studio-placeholder.png" class="img-fluid mx-auto" style="max-height: 400px">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 side-content">
                <h1><?php echo $studio['name']; ?></h1>
                <span class="address"><?php echo $studio['address']; ?></span>
                <div class="item_price">
                    <span class="price"
                          data-price="<?php echo $studio['price']; ?>"><?php echo format_price($studio['price']); ?></span>
                </div>
                <div class="item_description">
                    <p class="description">
                        <?php echo $studio['description'] ?: 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.'; ?>
                    </p>
                </div>
                <div class="w-100">
                    <li class="city__tag">
                        <a href="studios.php?cityIds=<?php echo $studio['geographical_information']['city_id']; ?>">
                            <?php echo $studio['geographical_information']['city']; ?>
                        </a>
                    </li>
                </div>
                <div class="col-12 mt-4 text-center">
                    <a href="javascript:void(0)" class="btn__reserve-studio hvr-grow-rotate" data-ripple="">رزرو
                        استدیو</a>
                </div>
            </div>
        </div>
        <?php if (count($suggestions)) : ?>
            <div class="row mt-3 mb-5">
                <div class="thead">
                    <h3 class="thead-sub">استدیوهای مشابه از نظر شهر و محدوده قیمت</h3>
                    <h2 class="thead-main">سایر پیشنهادها</h2>
                </div>
                <div class="w-100 row">
                    <?php for ($i = 0; $i < count($suggestions); $i++): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <?php $studio = $suggestions[$i]; ?>
                            <?php include 'views/cards/studio.php' ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>


<?php
include 'footer.php';
