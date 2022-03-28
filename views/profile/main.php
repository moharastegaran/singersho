<?php

if (isset($is_user_artist) && !$is_user_artist) : ?>
    <script> const pathSplit = window.location.pathname.split("/");
        window.location.href = pathSplit[pathSplit.length-1]; </script>
<?php endif; ?>
<?php

$artist_portfolio = $user['data']['other_info']['portfolio'];

$get_titles = callAPI('GET', RAW_API . 'titles', false);
$titles = json_decode($get_titles, true);
$titles = $titles['titles']['data'];

$get_artist_titles = callAPI('GET', RAW_API . 'title/my', false, true);
$artist_titles = json_decode($get_artist_titles, true);
$artist_titles = $artist_titles['titles'];

?>

<div class="user_is_artist row mx-auto">
    <div class="col-md-6">
        <div class="dashbox">
            <div class="dashbox__title">
                <h3>مهارت‌ها</h3>
                <button type="button" class="btn-green-outline btn-add btn-title-toggle" data-toggle="collapse"
                        data-target="#userAddTitleForm"> افزودن </button>
                <button type="button" class="btn-orange-outline btn-return btn-title-toggle d-none"
                        data-toggle="collapse" data-target="#userAddTitleForm">بازگشت</button>
            </div>
            <div class="dashbox__list-wrap">
                <form method="get" action="<?php echo RAW_API . 'title/artist'; ?>"
                      class="row collapse" id="userAddTitleForm">
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userTitleName">عنوان *</label>
                            <select id="userTitleName" name="name" class="sign__input required">
                                <option selected disabled>-- انتخاب کنید --</option>
                                <?php for ($i = 0; $i < count($titles); $i++) : ?>
                                    <option value="<?php echo $titles[$i]['id']; ?>">
                                        <?php echo $titles[$i]['name']; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userAcceptOrderPrice">هزینه انجام *</label>
                            <input id="userAcceptOrderPrice" type="number" autocomplete="off" name="order_price"
                                   class="sign__input required" placeholder="به تومان">
                        </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userTitleDescription">توضیحات
                                (اختیاری)</label>
                            <textarea id="userTitleDescription" rows="4" name="description" maxlength="191"
                                      class="sign__input" placeholder="توضیحات کامل تر = تعداد درخواست بیشتر"></textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-row flex-wrap justify-content-between align-items-center my-1">
                        <div class="n-chk">
                            <label class="new-checkbox checkbox-outline-green">
                                <input type="checkbox" class="new-control-input" name="accept_order">
                                <span class="new-control-indicator"></span> پذیرش انجام کار
                            </label>
                        </div>
                        <button type="submit" class="btn-purple">ذخیره</button>
                    </div>
                    <div class="col-12 text-left">
                    </div>
                </form>
                <ul class="col-12 title-list mt-4">
                    <?php if (count($artist_titles) > 0) : ?>
                        <?php for ($i = 0; $i < count($artist_titles); $i++) : ?>
                            <?php
                            $artist_title = $artist_titles[$i];
//                                            echo print_r($artist_title['pivot']['title_id']);
                            $artist_title['accept_order'] = $artist_title['pivot']['accept_order'];
                            $artist_title['order_price'] = $artist_title['pivot']['order_price'];
                            ?>
                            <?php include 'views/cards/artist_title.php' ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <div class="list-empty <?php echo count($artist_titles) > 0 ? 'd-none' : '' ?>">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m16 6a1 1 0 0 1 0 2h-8a1 1 0 0 1 0-2zm7.707 17.707a1 1 0 0 1 -1.414 0l-2.407-2.407a4.457 4.457 0 0 1 -2.386.7 4.5 4.5 0 1 1 4.5-4.5 4.457 4.457 0 0 1 -.7 2.386l2.407 2.407a1 1 0 0 1 0 1.414zm-6.207-3.707a2.5 2.5 0 1 0 -2.5-2.5 2.5 2.5 0 0 0 2.5 2.5zm-4.5 2h-6a3 3 0 0 1 -3-3v-14a3 3 0 0 1 3-3h12a1 1 0 0 1 1 1v8a1 1 0 0 0 2 0v-8a3 3 0 0 0 -3-3h-12a5.006 5.006 0 0 0 -5 5v14a5.006 5.006 0 0 0 5 5h6a1 1 0 0 0 0-2z"></path>
                        </svg>
                        <p>مهارتی افزوده نشده است</p>
                    </div>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashbox">
            <div class="dashbox__title">
                <h3>نمونه کارها</h3>
                <button type="button"
                        class="btn-green-outline btn-add btn-portfolio-toggle"
                        data-toggle="collapse" data-target="#userAddExperienceForm">
                    افزودن
                </button>
                <button type="button"
                        class="btn-orange-outline btn-return btn-portfolio-toggle d-none"
                        data-toggle="collapse" data-target="#userAddExperienceForm">
                    بازگشت
                </button>
            </div>
            <div class="dashbox__list-wrap">
                <form class="row collapse" id="userAddExperienceForm" method="get"
                      action="<?php echo RAW_API . 'portfolio/artist'; ?>" enctype="multipart/form-data">
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userExperienceTitle">عنوان *</label>
                            <input id="userExperienceTitle" type="text" autocomplete="off" name="name"
                                   class="sign__input" placeholder="نوازندگی موزیک متن سریال گاندو" required>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userExperienceDate">تاریخ انجام *</label>
                            <input id="userExperienceDate" type="text" autocomplete="off" name="date"
                                   class="sign__input" placeholder="1400/02/25" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="custom-file-container"
                             data-upload-id=userExperienceThumbnail>
                            <label>تصویر نمونه کار
                                <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                   title="حذف عکس">x</a>
                            </label>
                            <label class="custom-file-container__custom-file">
                                <input type="file" class="custom-file-container__custom-file__custom-file-input"
                                       name="image" accept="image/*">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            <div class="custom-file-container__image-preview"></div>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userExperienceDescription">توضیحات</label>
                            <textarea id="userExperienceDescription" name="description" class="sign__input"
                                      placeholder="توضیحات" rows="8" maxlength="191"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div id="rounded-circle-pills-icon-portfolio-external-url">
                            <div class="sign__group">
                                <label class="sign__label" for="userExperienceUrl">آدرس اینترنتی</label>
                                <input id="userExperienceUrl" type="url" autocomplete="off" name="url"
                                       class="sign__input" placeholder="آدرس اینترنتی">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-lg-2 my-1">
                        <div class="sign__group">
                            <label class="sign__label" for="userExperienceFileUpload">فایل نمونه کار</label>
                            <div class="input-group">
                                <input id="userExperienceFileUpload" type="file" class="sign__input" name="sound"
                                       accept="audio/*" autocomplete="off" placeholder="فایل نمونه کار">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-left">
                        <button type="submit" class="btn-purple">ذخیره</button>
                    </div>
                </form>
                <ul class="col-12 portfolio-list mt-4">
                    <?php if (count($artist_portfolio) > 0) : ?>
                        <?php for ($i = 0; $i < count($artist_portfolio); $i++) : ?>
                            <?php $portfolio = $artist_portfolio[$i]; ?>
                            <?php include 'views/cards/artist_portfolio.php' ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <div class="list-empty <?php echo count($artist_portfolio) > 0 ? 'd-none' : '' ?>">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="m16 6a1 1 0 0 1 0 2h-8a1 1 0 0 1 0-2zm7.707 17.707a1 1 0 0 1 -1.414 0l-2.407-2.407a4.457 4.457 0 0 1 -2.386.7 4.5 4.5 0 1 1 4.5-4.5 4.457 4.457 0 0 1 -.7 2.386l2.407 2.407a1 1 0 0 1 0 1.414zm-6.207-3.707a2.5 2.5 0 1 0 -2.5-2.5 2.5 2.5 0 0 0 2.5 2.5zm-4.5 2h-6a3 3 0 0 1 -3-3v-14a3 3 0 0 1 3-3h12a1 1 0 0 1 1 1v8a1 1 0 0 0 2 0v-8a3 3 0 0 0 -3-3h-12a5.006 5.006 0 0 0 -5 5v14a5.006 5.006 0 0 0 5 5h6a1 1 0 0 0 0-2z"></path>
                        </svg>
                        <p>نمونه کاری افزوده نشده است</p>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
