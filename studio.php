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
    $suggestions = array_values($suggestions);

    /* get studio times */
    $studio_times = array();
    $get_times = callAPI('GET', RAW_API . 'reservation/studio', ['rpp' => 100000, 'id' => $studio['id']]);
    $get_times = json_decode($get_times, true);
    if (!$get_times['error']) {
        $studio_times = $get_times['dates']['data'];
    }

    $cart_studio_reserve = array();
    if (isset($_SESSION['cart'])) {
        $cart_details = json_decode($_SESSION['cart'], true)['details'];
        $cart_studio_reserve = array_values(array_filter($cart_details, function ($item) {
            return $item['type'] === 'studio';
        }));
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


    <div class="container mx-auto studio__single" data-id="<?php echo $studio['id']; ?>">
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
                        <img src="assets/img/studio-placeholder.png" class="img-fluid mx-auto"
                             style="max-height: 400px">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 mt-md-0 mt-4">
                <div class="side-content">
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
                        <a href="#modal-topup" class="btn__reserve-studio hvr-grow-rotate d-block mx-md-3 mx-1"
                           data-ripple="">رزرو استدیو</a>
                    </div>
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
                            <?php $studio = $suggestions[$i];
                            include 'views/cards/studio.php' ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>


<?php

$cart_studio_reserve = array_column($cart_studio_reserve, 'id');
if (isset($studio_times) && count($studio_times)) : ?>
    <div id="modal-topup" class="mfp-hide magnific-modal">
        <button class="modal__close" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
            </svg>
        </button>
        <h4 class="modal__title">تعیین زمان رزرو</h4>

        <ul class="listicon mb-4 mt-4">
            <li class="listicon-item item-large">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <?php echo $get_studio['studio']['name']; ?>
            </li>
            <li class="listicon-item item-large">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20.457,4.555,12.486.126a1,1,0,0,0-.972,0L3.543,4.555A3,3,0,0,0,2,7.177V19a5.006,5.006,0,0,0,5,5H17a5.006,5.006,0,0,0,5-5V7.177A3,3,0,0,0,20.457,4.555ZM20,19a3,3,0,0,1-3,3H7a3,3,0,0,1-3-3V7.177A1,1,0,0,1,4.515,6.3L12,2.144,19.486,6.3A1,1,0,0,1,20,7.177Z"/>
                    <circle cx="12" cy="7" r="1.5"/>
                </svg>
                ساعتی <strong
                        class="faNum mx-1"><?php echo format_price($get_studio['studio']['price']); ?></strong>تومان
            </li>
        </ul>

        <div class="sign__group reserve__dates-select mb-0">
            <select name="reserve__days-select">
                <?php for ($i = 0; $i < count($studio_times); $i++) { ?>
                    <option value="<?php echo $studio_times[$i]['shamsi_date_2']; ?>">
                        <?php echo $studio_times[$i]['shamsi_date_1']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <?php
        $current_time = $studio_times[0];
        if (count($current_time['details'])) {
            $current_time_details = $current_time['details'];
            echo "<ul class='reserve__times-list mb-4'>";
            for ($j = 0; $j < count($current_time_details); $j++) : ?>
                <?php if (!$current_time_details[$j]['is_reserve']) : ?>
                    <li class="reserve__time-badge <?php echo in_array($current_time_details[$j]['id'], $cart_studio_reserve) ? ' selected' : ''; ?>">
                        <a href="javascript:void(0)" data-id="<?php echo $current_time_details[$j]['id']; ?>">
                            <?php echo $current_time_details[$j]['allowed_hour']['started_at'] . ' تا ' . $current_time_details[$j]['allowed_hour']['ended_at']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor;
            echo "</ul>";
        } ?>
        <p class="reserve__help-block">
            کافیست بر روی ساعت مورد نظر کلیک کنید
        </p>
    </div>
<?php endif;

include 'footer.php';
