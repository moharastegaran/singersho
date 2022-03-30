<?php

include 'header.php';

$params = isset($_GET['params']) ? $_GET['params'] : $_SERVER['QUERY_STRING'];
$params = query_string_to_array($params, ['rpp' => 12]);

$get_artists = callAPI('GET', RAW_API . 'artists', $params);
$artists = json_decode($get_artists, true);
$data = $artists['artists']['data'];
$links = $artists['artists']['links'];


$get_titles = callAPI('GET', RAW_API . 'titles', false);
$titles = json_decode($get_titles, true);
$titles = $titles['titles']['data'];
?>
    <div id="list__main-container" class="container-fluid">
        <div class="row px-0 mx-auto">
            <div class="filters__total-back"></div>
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
                                            <span>سبک ها</span>
                                        </div>
                                        <div class="filter__single-wrap">
                                            <ul class="filter__list">
                                                <?php for ($i = 0; $i < count($titles); $i++) : ?>
                                                    <li class="filter__list-item">
                                                        <span class="filter__list-itemdel"></span>
                                                        <div class="filter__checkbox">
                                                            <input type="radio"
                                                                   id="<?php echo 'title__' . $titles[$i]['id']; ?>"
                                                                   value="title=<?php echo $titles[$i]['name']; ?>"
                                                                   name="title">
                                                            <span class="filter__checkmark"></span>
                                                            <label for="<?php echo 'title__' . $titles[$i]['id']; ?>"><?php echo $titles[$i]['name']; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="filter__single">
                                        <div class="filter__title">
                                            <img src="assets/img/filter.png" class="img-fluid">
                                            <span>نام هنرمند</span>
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
                                            <span>هزینه مشاوره</span>
                                        </div>
                                        <div class="filter__single-wrap">
                                            <div class="slider" data-mmin="<?php echo $artists['ap_min']; ?>"
                                                 data-mmax="<?php echo $artists['ap_max']; ?>"
                                                 data-value-0="#slider-range-min" data-value-1="#slider-range-max"
                                                 data-range="#third"></div>
                                            <div class="slider__range-results row mt-3">
                                                <div class="col-6 d-flex flex-column align-items-center text-center">
                                                    <span>تا</span>
                                                    <span class="slider-range-max" id="slider-range-max"></span>
                                                    <span>تومان</span>
                                                </div>
                                                <div class="col-6 d-flex flex-column align-items-center text-center">
                                                    <span>از</span>
                                                    <span class="slider-range-min" id="slider-range-min"></span>
                                                    <span>تومان</span>
                                                </div>
                                            </div>
                                            <div class="filter__slider-range--addon">
                                                <button class="filter__slider-range--btn">اعمال</button>
                                                <span class="filter__list-itemdel"></span>
                                            </div>
                                        </div>
                                    </li>

                                    <!--                                <li class="filter__single">-->
                                    <!--                                    <div class="filter__title">-->
                                    <!--                                        <img src="assets/img/filter.png" class="img-fluid">-->
                                    <!--                                        <span>مشاوره</span>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="filter__single-wrap">-->
                                    <!--                                        <div class="d-flex flex-nowrap justify-content-between align-items-center mb-3 mt-2">-->
                                    <!--                                            <span class="filter__switch-title">مشاوره می دهد</span>-->
                                    <!--                                            <label class="switch s-icons s-outline  s-outline-success">-->
                                    <!--                                                <input type="checkbox" name="is_advisor" checked="">-->
                                    <!--                                                <span class="switch-slider round"></span>-->
                                    <!--                                            </label>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                </li>-->

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">

                <div class="page-title page-artists">
                    <h1>هنرمندان</h1>
                </div>

                <div id="list___main-header">
                    <div class="sorting">
                        <!--                        <img src="assets/img/icons/align-left.svg" class="ml-1">-->
                        <span style="font-size: 13px; color: #aaa">مرتب‌سازی بر اساس :</span>
                        <div class="css-select">
                            <input type="hidden" name="select__sort-order" value="" data-css-select="hidden"/>
                            <input type="text" class="css-select__selected" value="پیشفرض" readonly
                                   data-css-select="selected"/>
                            <div class="css-select__dropdown">
                                <button type="button" class="css-select__option"
                                        data-css-select="column=id&isDesc=1">جدیدتر
                                </button>
                                <button type="button" class="css-select__option"
                                        data-css-select="column=id&isDesc=0">قدیمی‌تر
                                </button>
                                <button type="button" class="css-select__option"
                                        data-css-select="column=delivery_time&isDesc=1">بازه تحویل
                                </button>
                                <button type="button" class="css-select__option"
                                        data-css-select="column=advise_price&isDesc=1">هزینه مشاوره
                                </button>
                            </div>
                        </div>
                    </div>
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
                        <?php for ($i = 0; $i < count($data); $i++) : ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 px-0">
                                <?php $artist = $data[$i]; ?>
                                <?php include 'views/cards/artist.php' ?>
                            </div>
                        <?php endfor; ?>

                        <?php include 'views/cards/pagination.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php';
