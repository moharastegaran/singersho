<?php

include 'header.php';
if (isset($_GET['id'])) {
    $get_artist = callAPI('GET', RAW_API . 'artist/' . $_GET['id'] . '/detail', false);
    $get_artist = json_decode($get_artist, true);
    if (!$get_artist['error']) {
        $artist = $get_artist['data'];
    } else {
        die("artist not found");
    }

    $artist_is_advisor = $artist['artist']['is_advisor'] == 1 && $artist['artist']['advise_price'] > 0;

    if ($artist_is_advisor) {
        $get_times = callAPI('GET', RAW_API . 'reservation/advisor', ['rpp' => 1000, 'id' => $artist['artist']['id']]);
        $get_times = json_decode($get_times, true);
        if (!$get_times['error']) {
            $times = $get_times['dates']['data'];
        }
    }

    $cart_advisors = array();
    if (isset($_SESSION['cart'])) {
        $cart_details = json_decode($_SESSION['cart'], true)['details'];
        $cart_advisors = array_values(array_filter($cart_details, function ($item) {
            return $item['type'] === 'advisor';
        }));
    }
}
?>

    <div class="container mx-auto artist__single" data-id="<?php echo $artist['artist']['id']; ?>">
        <nav aria-label="breadcrumbs">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" title="خانه">خانه</a></li>
                <li class="breadcrumb-item"><a href="artists.php" title="هنرمندان">هنرمندان</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo $artist['artist']['first_name'] . ' ' . $artist['artist']['last_name']; ?>
                </li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-lg-3 col-md-3 px-md-2" style="overflow: visible !important;">
                <div class="artist__side-panel fixed-element" style="position: static; top: 0">
                    <div class="artist__image-container">
                        <img src="<?php echo $artist['artist']['avatar'] ?: 'assets/img/artist-avatar-placeholder.png' ?>">
                    </div>
                    <div class="artist__profile-info">
                        <h1 class="fullname">
                            <?php echo $artist['artist']['first_name'] . ' ' . $artist['artist']['last_name']; ?>
                        </h1>
                        <ul class="artist__info-list">
                            <li class="artist__info-list-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M22.319,4.431,8.5,18.249a1,1,0,0,1-1.417,0L1.739,12.9a1,1,0,0,0-1.417,0h0a1,1,0,0,0,0,1.417l5.346,5.345a3.008,3.008,0,0,0,4.25,0L23.736,5.847a1,1,0,0,0,0-1.416h0A1,1,0,0,0,22.319,4.431Z"/>
                                </svg>
                                <span>مشاوره می‌دهد</span>
                                <p class="is_advisor main__table-text--<?php echo $artist_is_advisor ? 'approval' : 'failed' ?>">
                                    <?php echo $artist_is_advisor ? 'بله' : 'خیر'; ?>
                                </p>
                            </li>
                            <?php if ($artist_is_advisor): ?>
                                <li class="artist__info-list-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M20.457,4.555,12.486.126a1,1,0,0,0-.972,0L3.543,4.555A3,3,0,0,0,2,7.177V19a5.006,5.006,0,0,0,5,5H17a5.006,5.006,0,0,0,5-5V7.177A3,3,0,0,0,20.457,4.555ZM20,19a3,3,0,0,1-3,3H7a3,3,0,0,1-3-3V7.177A1,1,0,0,1,4.515,6.3L12,2.144,19.486,6.3A1,1,0,0,1,20,7.177Z"/>
                                        <circle cx="12" cy="7" r="1.5"/>
                                    </svg>
                                    <span>هزینه مشاوره</span>
                                    <p class="advise_price"
                                       data-price="<?php echo $artist['artist']['advise_price']; ?>">
                                        <?php echo 'ساعتی ' . format_price($artist['artist']['advise_price']) . ' تومان' ?>
                                    </p>

                                    <?php if (isset($times) && count($times)) : ?>
                                        <a href="#modal-topup" class="select__advisor"
                                           data-id="<?php echo $artist['artist']['id']; ?>">درخواست مشاوره</a>
                                    <?php else :  ?>
                                        <span class="text-warning" style="opacity: .5">ساعات رزرو تکمیل شده اند.</span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                            <li class="artist__info-list-item">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m14.6 21.3c-.3.226-.619.464-.89.7h2.29a1 1 0 0 1 0 2h-4a1 1 0 0 1 -1-1c0-1.5 1.275-2.456 2.4-3.3.75-.562 1.6-1.2 1.6-1.7a1 1 0 0 0 -2 0 1 1 0 0 1 -2 0 3 3 0 0 1 6 0c0 1.5-1.275 2.456-2.4 3.3zm8.4-6.3a1 1 0 0 0 -1 1v3h-1a1 1 0 0 1 -1-1v-2a1 1 0 0 0 -2 0v2a3 3 0 0 0 3 3h1v2a1 1 0 0 0 2 0v-7a1 1 0 0 0 -1-1zm-10-3v-5a1 1 0 0 0 -2 0v4h-3a1 1 0 0 0 0 2h4a1 1 0 0 0 1-1zm10-10a1 1 0 0 0 -1 1v2.374a12 12 0 1 0 -14.364 17.808 1.015 1.015 0 0 0 .364.068 1 1 0 0 0 .364-1.932 10 10 0 1 1 12.272-14.318h-2.636a1 1 0 0 0 0 2h3a3 3 0 0 0 3-3v-3a1 1 0 0 0 -1-1z"/>
                                </svg>
                                <span>مدت تحویل</span>
                                <p class="delivery_time"
                                   data-delivery-time="<?php echo $artist['artist']['delivery_time']; ?>">
                                    <?php echo format_price($artist['artist']['delivery_time']) . ' روز' ?>
                                </p>
                            </li>
                        </ul>
                        <div style="padding-left: 40px;padding-right: 40px">
                            <!--                        --><?php //if (count($artist['titles'])) : ?>
                            <!--                            <div class="css-select w-100">-->
                            <!--                                <input type="hidden" name="artist_title_id" value="" data-css-select="hidden"/>-->
                            <!--                                <input type="text" class="css-select__selected" value="انتخاب مهارت" readonly-->
                            <!--                                       data-css-select="selected"/>-->
                            <!--                                <div class="css-select__dropdown">-->
                            <!--                                    --><?php //for ($i = 0; $i < count($artist['titles']); $i++) : ?>
                            <!--                                        <button type="button" class="css-select__option"-->
                            <!--                                                data-css-select="-->
                            <?php //echo $artist['titles'][$i]['id']; ?><!--">-->
                            <!--                                            --><?php //echo $artist['titles'][$i]['name']; ?>
                            <!--                                        </button>-->
                            <!--                                    --><?php //endfor; ?>
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                        --><?php //endif; ?>
                            <!--                        --><?php //if ($artist['artist']['is_advisor'] == 1) : ?>
                            <!--                            <div class="col-12 text-right my-2">-->
                            <!--                                <div class="n-chk">-->
                            <!--                                    <label class="new-checkbox new-checkbox-rounded checkbox-outline-green">-->
                            <!--                                        <input type="radio" class="new-control-input" name="artist_type" value="teammate"-->
                            <!--                                               checked="">-->
                            <!--                                        <span class="new-control-indicator"></span> مهارت-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                                <div class="n-chk">-->
                            <!--                                    <label class="new-checkbox new-checkbox-rounded checkbox-outline-green">-->
                            <!--                                        <input type="radio" class="new-control-input" name="artist_type" value="advisor">-->
                            <!--                                        <span class="new-control-indicator"></span> مشاوره-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                                <div class="n-chk">-->
                            <!--                                    <label class="new-checkbox new-checkbox-rounded checkbox-outline-green">-->
                            <!--                                        <input type="radio" class="new-control-input" name="artist_type"-->
                            <!--                                               value="advisor_teammate">-->
                            <!--                                        <span class="new-control-indicator"></span> هر دو-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                        --><?php //endif; ?>
                            <!--                        <a href="javascript:void(0)" class="btn__buy-artist w-100">انتخاب هنرمند</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 px-md-5 mt-md-0 mt-5">
                <div class="artist__bio mb-5">
                    <div class="thead"><h2 class="thead-main">توضیحات</h2></div>
<!--                    --><?php //var_dump($artist['artist']['experience']===null);die(); ?>
                    <?php if ($artist['artist']['experience'] !== null || $artist['artist']['order_description'] !== null) : ?>
                        <p class="experience"><?php echo $artist['artist']['experience']; ?></p>
                        <p class="order_description"><?php echo $artist['artist']['order_description']; ?></p>
                    <?php else : ?>
                        <p class="experience">اطلاعاتی برای نمایش ثبت نشده است.</p>
                    <?php endif; ?>
                </div>

                <div class="artist__titles my-5">
                    <div class="thead"><h2 class="thead-main">مهارت‌ها</h2></div>
                    <?php if (count($artist['titles'])) : ?>
                        <?php $_titles = $artist['titles']; ?>
                        <?php for ($i = 0; $i < count($_titles); $i++) : ?>
                            <li class="artist__title-item">
                            <span class="artist__title-item-title">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path
                                            d="M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z"></path></svg>
                                <?php echo $_titles[$i]['name']; ?>
                            </span>
                                <?php if ($_titles[$i]['pivot']['accept_order'] == 1) : ?>
                                    <a class="select__title" data-id="<?php echo $_titles[$i]['pivot']['id']; ?>">
                                        انتخاب
                                        (<?php echo '<span class="faNum">' . format_price($_titles[$i]['pivot']['order_price']) . ' تومان</span>' ?>
                                        )
                                    </a>
                                <?php else : ?>
                                    <a class="noselect__title">غیر قابل انتخاب</a>
                                <?php endif; ?>
                                <!--                                    <div>-->
                                <!--                                        <strong class="accepts_order ml-2">سفارش می‌پذیرد</strong>-->
                                <!--                                        <span class="order_price">-->
                                <?php //echo format_price($_titles[$i]['pivot']['order_price']) . ' تومان'; ?><!--</span>-->
                                <?php if (!empty($_titles[$i]['pivot']['description'])) : ?>
                                    <p class="description"><?php echo $_titles[$i]['pivot']['description']; ?></p>
                                <?php endif; ?>
                                <!--                                    </div>-->
                            </li>
                        <?php endfor; ?>
                    <?php else : ?>
                        <p class="experience"> مهارتی برای نمایش وجود ندارد.</p>
                    <?php endif; ?>
                </div>

                <div class="artist__portfolios my-5">
                    <div class="thead"><h2 class="thead-main">نمونه‌کارها</h2></div>
                    <?php if (count($artist['portfolio'])) : ?>
                        <div class="row">
                            <?php $_portfolio = $artist['portfolio']; ?>
                            <?php for ($i = 0; $i < count($_portfolio); $i++) : ?>
                                <div class="col-sm-6 col-12">
                                    <div class="artist__portfolio-item">
                                        <a class="artist__portfolio-cover"
                                           style="background-image: url(<?php echo !empty($_portfolio[$i]['image']) ? $_portfolio[$i]['image'] : ''; ?>)"
                                           data-title="<?php echo $_portfolio[$i]['name']; ?>"
                                           data-artist="<?php echo $artist['artist']['first_name'] . ' ' . $artist['artist']['last_name']; ?>"
                                           data-img="<?php echo $_portfolio[$i]['image']; ?>"
                                            <?php switch (strtoupper($_portfolio[$i]['type'])) :
                                                case 'URL' : ?>
                                                    href="<?php echo $_portfolio[$i]['url']; ?>" target="_blank"
                                                    <?php break; ?><?php case 'SOUND': ?><?php break; ?><?php endswitch; ?>>
                                            <span class="artist__portfolio-date"><?php echo $_portfolio[$i]['date']; ?></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                 stroke="#fca311" stroke-width="1.7" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <?php switch (strtoupper($_portfolio[$i]['type'])) :
                                                    case 'URL': ?>
                                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                                        <?php break; ?>
                                                    <?php case 'SOUND': ?>
                                                        <path d=\"M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z\"></path>'
                                                        <?php break; ?>
                                                    <?php endswitch; ?>
                                            </svg>
                                        </a>
                                        <h3 class="artist__portfolio-content">
                                            <a href="#"
                                               class="artist__portfolio-name"><?php echo $_portfolio[$i]['name']; ?></a>
                                            <p class="artist__portfolio-description"><?php echo $_portfolio[$i]['description']; ?></p>
                                        </h3>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php else : ?>
                        <p class="experience"> نمونه کاری برای نمایش وجود ندارد.</p>
                    <?php endif; ?>
                </div>

                <?php if (count($artist['packages'])) : ?>
                    <div class="artist__packages mt-sm-4 mb-sm-3 my-5">
                        <div class="thead"><h2 class="thead-main">پکیج‌ها</h2></div>
                        <div class="row">
                            <?php $_packages = $artist['packages']; ?>
                            <?php for ($i = 0; $i < count($_packages); $i++) : ?>
                                <div class="col-lg-4 artist__portfolio-item">
                                    <div class="artist__portfolio-cover"
                                         style="background-image: url(<?php echo !empty($_packages[$i]['image']) ? $_packages[$i]['image'] : ''; ?>)"></div>
                                    <a href="package.php?id=<?php echo $_packages[$i]['id']; ?>"
                                       class="artist__portfolio-name">
                                        <?php echo $_packages[$i]['name']; ?>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php
$cart_advisors = array_column($cart_advisors, 'id');
if (isset($times) && count($times)) : ?>
    <div id="modal-topup" class="mfp-hide magnific-modal">
        <button class="modal__close" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
            </svg>
        </button>
        <h4 class="modal__title">تعیین زمان مشاوره</h4>

        <ul class="listicon mb-4 mt-4">
            <li class="listicon-item item-large">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <?php echo $artist['artist']['first_name'] . ' ' . $artist['artist']['last_name']; ?>
            </li>
            <li class="listicon-item item-large">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20.457,4.555,12.486.126a1,1,0,0,0-.972,0L3.543,4.555A3,3,0,0,0,2,7.177V19a5.006,5.006,0,0,0,5,5H17a5.006,5.006,0,0,0,5-5V7.177A3,3,0,0,0,20.457,4.555ZM20,19a3,3,0,0,1-3,3H7a3,3,0,0,1-3-3V7.177A1,1,0,0,1,4.515,6.3L12,2.144,19.486,6.3A1,1,0,0,1,20,7.177Z"/>
                    <circle cx="12" cy="7" r="1.5"/>
                </svg>
                ساعتی <strong
                        class="faNum mx-1"><?php echo format_price($artist['artist']['advise_price']); ?></strong>تومان
            </li>
        </ul>
        <!--        <div class="advisor__days-selectrow row justify-content-between align-items-center px-4 mt-4">-->
        <!--            <a href="javascript:void(0)" class="advisor__day-prev disabled" data-id="0">-->
        <!--                <i class="fas fa-chevron-right ml-1"></i>-->
        <!--                قبلی-->
        <!--            </a>-->
        <div class="sign__group advisor__dates-select mb-0">
            <select name="advisor__days-select">
                <?php for ($i = 0; $i < count($times); $i++) { ?>
                    <option value="<?php echo $times[$i]['shamsi_date_2']; ?>">
                        <?php echo $times[$i]['shamsi_date_1']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <!--            <a href="javascript:void(0)" class="advisor__day-next -->
        <?php //echo count($times) === 1 ? 'disabled' : ''; ?><!--"-->
        <!--               data-id="2">-->
        <!--                بعدی-->
        <!--                <i class="fas fa-chevron-left mr-1"></i>-->
        <!--            </a>-->
        <!--        </div>-->

        <?php
        $current_time = $times[0];
        if (count($current_time['details'])) {
            $current_time_details = $current_time['details'];
            echo "<ul class='advisor__times-list mb-4'>";
            for ($j = 0; $j < count($current_time_details); $j++) : ?>
                <?php if (!$current_time_details[$j]['is_reserve']) : ?>
                    <li class="advisor__time-badge <?php echo in_array($current_time_details[$j]['id'], $cart_advisors) ? ' selected' : ''; ?>">
                        <a href="javascript:void(0)" data-id="<?php echo $current_time_details[$j]['id']; ?>">
                            <?php echo $current_time_details[$j]['allowed_hour']['started_at'] . ' تا ' . $current_time_details[$j]['allowed_hour']['ended_at']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor;
            echo "</ul>";
        } ?>
        <!--                <ul class="advisor__times-list">-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">10:30 تا 11</a></li>-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">11 تا 11:30</a></li>-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">11:30 تا 12</a></li>-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">12:30 تا 13</a></li>-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">13:30 تا 14</a></li>-->
        <!--                    <li class="advisor__time-badge"><a href="javascript:void(0)">14:30 تا 15</a></li>-->
        <!--                </ul>-->
        <p class="advisor__help-block">
            کافیست بر روی ساعت مورد نظر کلیک کنید
        </p>
    </div>
<?php endif;

include 'footer.php';