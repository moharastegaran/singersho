<?php

include 'header.php';

$params = isset($_GET['params']) ? $_GET['params'] : $_SERVER['QUERY_STRING'];
$params = query_string_to_array($params, ['rpp' => 12]);

$get_packages = callAPI('GET', RAW_API . 'packages', $params);
$packages = json_decode($get_packages, true);
$data = $packages['packages']['data'];
$links = $packages['packages']['links'];
$price_min = $packages['p_min'];
$price_max = $packages['p_max'];

?>
    <div id="list__main-container" class="container-fluid">
        <div class="row px-0 mx-auto">
            <div class="col-xl-3 col-lg-4 filters__total-container">
                <div class="filters__total-wrap">
                    <button class="filters__hide-btn"><i class="fas fa-times ml-3"></i>خروج</button>
                    <div class="search-sidebar">
                        <button class="btn--orange btn--full filter__reset">لغو فیلترها</button>

                        <div class="filter">
                            <div class="filter__wrap">
                                <ul>
                                    <li class="filter__single filter__single-cb">
                                        <div class="filter__title">
                                            <img src="assets/img/filter.png" class="img-fluid">
                                            <span>مرتب‌سازی</span>
                                        </div>
                                        <div class="filter__single-wrap">
                                            <ul class="filter__list">
                                                <li class="filter__list-item">
                                                    <span class="filter__list-itemdel"></span>
                                                    <div class="filter__checkbox">
                                                        <input type="radio"
                                                               id="sortingorder__priceDesc"
                                                               value="column=price&isDesc=1" name="title">
                                                        <span class="filter__checkmark"></span>
                                                        <label for="sortingorder__priceDesc">گران ترین</label>
                                                    </div>
                                                </li>
                                                <li class="filter__list-item">
                                                    <span class="filter__list-itemdel"></span>
                                                    <div class="filter__checkbox">
                                                        <input type="radio"
                                                               id="sortingorder__priceNotDesc"
                                                               value="column=price&isDesc=0" name="title">
                                                        <span class="filter__checkmark"></span>
                                                        <label for="sortingorder__priceNotDesc">ارزان ترین</label>
                                                    </div>
                                                </li>
                                                <li class="filter__list-item">
                                                    <span class="filter__list-itemdel"></span>
                                                    <div class="filter__checkbox">
                                                        <input type="radio"
                                                               id="sortingorder__oldest"
                                                               value="column=id&isDesc=0" name="title">
                                                        <span class="filter__checkmark"></span>
                                                        <label for="sortingorder__oldest">قدیمی ترین</label>
                                                    </div>
                                                </li>
                                                <li class="filter__list-item">
                                                    <span class="filter__list-itemdel"></span>
                                                    <div class="filter__checkbox">
                                                        <input type="radio"
                                                               id="sortingorder__youngest"
                                                               value="column=id&isDesc=1" name="title">
                                                        <span class="filter__checkmark"></span>
                                                        <label for="sortingorder__youngest">جدید ترین</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="filter__single">
                                        <div class="filter__title">
                                            <img src="assets/img/filter.png" class="img-fluid">
                                            <span>نام پکیج</span>
                                        </div>
                                        <div class="filter__single-wrap">
                                            <div id="filter__name-wrap">
                                                <form id="filter__name-form" method="get" action="">
                                                    <input type="text" name="search" autocomplete="off"
                                                           placeholder="جست و جو کنید" required>
                                                    <div class="form-group--addon">
                                                        <span class="form-group--seperator"></span>
                                                        <div aria-hidden="true" class="form-group--icobtn">
                                                            <button type="submit">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24">
                                                                    <path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <span class="filter__list-itemdel"></span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="filter__single filter__single-range">
                                        <div class="filter__title">
                                            <img src="assets/img/filter.png" class="img-fluid">
                                            <span>هزینه پکیج</span>
                                        </div>
                                        <div class="filter__single-wrap filter__single-formrange">
                                            <form method="get">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="number" name="price_min" placeholder="از ..."
                                                               min="<?php echo $price_min; ?>"
                                                               max="<?php echo $price_max; ?>">
                                                        <div class="help-block">
                                                            <?php echo format_price($price_min); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" name="price_max" placeholder="تا ..."
                                                               min="<?php echo $price_min; ?>"
                                                               max="<?php echo $price_max; ?>">
                                                        <div class="help-block">
                                                            <?php echo format_price($price_max); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filter__slider-range--addon">
                                                    <button type="submit" class="btn-custom-dark">اعمال</button>
                                                    <span class="filter__list-itemdel"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">

                <div class="page-title page-packages">
                    <h1>فروشگاه</h1>
                </div>

                <div id="list___main-header">
                    <!--                    <div class="sorting">-->
                    <!--                                                <img src="assets/img/icons/align-left.svg" class="ml-1">-->
                    <!--                        <span style="font-size: 13px; color: #aaa">مرتب‌سازی بر اساس :</span>-->
                    <!--                        <div class="css-select">-->
                    <!--                            <input type="hidden" name="select__sort-order" value="" data-css-select="hidden"/>-->
                    <!--                            <input type="text" class="css-select__selected" value="پیشفرض" readonly-->
                    <!--                                   data-css-select="selected"/>-->
                    <!--                            <div class="css-select__dropdown">-->
                    <!--                                <button type="button" class="css-select__option"-->
                    <!--                                        data-css-select="column=created_at&isDesk=1">جدیدتر-->
                    <!--                                </button>-->
                    <!--                                <button type="button" class="css-select__option"-->
                    <!--                                        data-css-select="column=created_at&isDesk=0">قدیمی‌تر-->
                    <!--                                </button>-->
                    <!--                                <button type="button" class="css-select__option"-->
                    <!--                                        data-css-select="column=delivery_time&isDesk=1">بازه تحویل-->
                    <!--                                </button>-->
                    <!--                                <button type="button" class="css-select__option"-->
                    <!--                                        data-css-select="column=advise_price&isDesk=1">هزینه مشاوره-->
                    <!--                                </button>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="ul-rpp">
                        <img src="assets/img/icons/apps-sort.svg">
                        <a href="javascript:void(0)" class="rpp-number rpp-current" data-rpp="12"><span>12</span></a>
                        <span class="rpp-border"></span>
                        <a href="javascript:void(0)" class="rpp-number" data-rpp="24"><span>24</span></a>
                        <span class="rpp-border"></span>
                        <a href="javascript:void(0)" class="rpp-number" data-rpp="36"><span>36</span></a>
                        <span class="per-page-border"></span>
                    </div>
                </div>

                <div class="responsive-filterbar-toggle">
                    <a href="javascript:void(0)">
                        <i class="fas fa-bars"></i>
                        نمایش فیلتربار
                    </a>
                </div>

                <div id="lists__main-list">
                    <div id="main-list-empty" class="d-none">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                            <path d="m16 6a1 1 0 0 1 0 2h-8a1 1 0 0 1 0-2zm7.707 17.707a1 1 0 0 1 -1.414 0l-2.407-2.407a4.457 4.457 0 0 1 -2.386.7 4.5 4.5 0 1 1 4.5-4.5 4.457 4.457 0 0 1 -.7 2.386l2.407 2.407a1 1 0 0 1 0 1.414zm-6.207-3.707a2.5 2.5 0 1 0 -2.5-2.5 2.5 2.5 0 0 0 2.5 2.5zm-4.5 2h-6a3 3 0 0 1 -3-3v-14a3 3 0 0 1 3-3h12a1 1 0 0 1 1 1v8a1 1 0 0 0 2 0v-8a3 3 0 0 0 -3-3h-12a5.006 5.006 0 0 0 -5 5v14a5.006 5.006 0 0 0 5 5h6a1 1 0 0 0 0-2z"/>
                        </svg>
                        <p>نتیجه‌ای یافت نشد</p>
                    </div>
                    <div class="row">
                        <?php
                        $packageIds = array();
                        if (isset($_SESSION['cart'])) {
                            $cart_details = json_decode($_SESSION['cart'], true);
                            $cart_details = $cart_details['details'];
                            if (count($cart_details)) {
                                for ($j = 0; $j < count($cart_details); $j++) {
                                    if ($cart_details[$j]['type'] === 'package') {
                                        array_push($packageIds, $cart_details[$j]['id']);
                                    }
                                }
                            }
                        }
                        for ($i = 0; $i < count($data); $i++) : ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 px-xl-3 px-2">
                                <?php $package = $data[$i]; ?>
                                <?php $package['in_cart'] = in_array($package['id'], $packageIds) ?>
                                <?php include 'views/cards/package.php' ?>
                            </div>
                        <?php endfor; ?>

                        <?php include 'views/cards/pagination.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php';
