<?php

global $user;

$get_studios = callAPI('GET', RAW_API . 'studio/my?column=id&isDesc=1', false, true);
$studios = json_decode($get_studios, true);
$has_error = $studios['error'];
$studios = $studios['studios'];

$get_cities = callAPI('GET', RAW_API . 'cities', ['rpp' => 2000]);
$get_cities = json_decode($get_cities, true);
$cities = array();
if (!($has_error = $get_cities['error']))
    $cities = $get_cities['cities']['data'];
?>


<div class="dashbox">
    <div class="dashbox__title">
        <h3>استدیوهای من</h3>
    </div>
    <?php if (count($studios)) : ?>
        <div class="dashbox__table-wrap">
            <div class="dashbox__table-scroll">
                <div class="scroll-content">
                    <table class="main__table studios_table">
                        <thead>
                        <tr>
                            <th style="width: 9%"><a href="javascript:void(0)">
                                    #
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width: 10%"><a href="javascript:void(0)">
                                    در دسترس
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width:25%"><a href="javascript:void(0)">
                                    نام
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width: 15%"><a href="javascript:void(0)">
                                    شهر
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width: 15%"><a href="javascript:void(0)">
                                    هزینه اجاره
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width: 15%"><a href="javascript:void(0)">
                                    وضعیت
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M9.71,10.21,12,7.91l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-3-3a1,1,0,0,0-1.42,0l-3,3a1,1,0,0,0,1.42,1.42Zm4.58,4.58L12,17.09l-2.29-2.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,1.42,0l3-3a1,1,0,0,0-1.42-1.42Z"></path>
                                    </svg>
                                </a></th>
                            <th style="width: 11%"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <!----------------------->
                        <!--  inline edit row  -->
                        <!----------------------->
                        <tr class="inline-edit-row d-none">
                            <td colspan="7">
                                <div class="row py-3">
                                    <h6 class="col-12 mb-4">ویرایش سریع</h6>
                                    <div class="col-md-6">
                                        <div class="sign__group d-flex">
                                            <label class="col-lg-2 col-md-3 col-12 sign__label light" for="name">نام</label>
                                            <div class="col-lg-10 col-md-9 col-12">
                                                <input type="text" id="name" name="name" autocomplete="off"
                                                       class="sign__input" required>
                                            </div>
                                        </div>
                                        <div class="sign__group d-flex">
                                            <label class="col-lg-2 col-md-3 col-12 sign__label light"
                                                   for="studioCity">شهر</label>
                                            <div class="col-lg-10 col-md-9 col-12">
                                                <input id="studioCity" type="text" class="sign__select"
                                                       autocomplete="off" name="city_name">
                                                <input id="studioCityID" type="hidden" name="city_id">
                                                <ul class="list-group-flush list-group__cities"
                                                    style="max-height: 100px;z-index: 9999;position: absolute;left: 0;right: 0">
                                                    <?php if (!$has_error) : ?>
                                                        <?php for ($i = 0; $i < count($cities); $i++) : ?>
                                                            <li class="list-group-item bg-dark text-light d-none p-1"
                                                                style="font-size: 13px;cursor: pointer"
                                                                data-id="<?php echo $cities[$i]['id']; ?>">
                                                                <?php echo $cities[$i]['name']; ?>
                                                            </li>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="sign__group d-flex">
                                            <label class="col-lg-2 col-md-3 col-12 sign__label light"
                                                   for="studioRentCostInput">هزینه</label>
                                            <div class="col-lg-10 col-md-9 col-12">
                                                <input type="number" id="studioRentCostInput" autocomplete="off"
                                                       name="price" class="sign__input" required>
                                            </div>
                                        </div>
                                        <div class="sign__group d-flex">
                                            <label class="col-lg-2 col-md-3 col-12 sign__label light">آدرس</label>
                                            <div class="col-lg-10 col-md-9 col-12">
                                                <textarea rows="4" name="address" class="sign__input"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-file-container" data-upload-id="studioImagesFileContainer">
                                            <label class="sign__label light">
                                                آپلود عکس(ها)
                                                <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                                   title="حذف همه">x</a>
                                            </label>
                                            <label class="custom-file-container__custom-file">
                                                <input type="file" name="images[]" accept="image/*"
                                                       class="custom-file-container__custom-file__custom-file-input"
                                                       multiple="">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                <!--                                            <span class="custom-file-container__custom-file__custom-file-control">انتخاب کنید...-->
                                                <!--                                            <span class="custom-file-container__custom-file__custom-file-control__button"> جست‌وجو </span>-->
                                                <!--                                            </span>-->
                                            </label>
                                            <div class="custom-file-container__image-preview"
                                                 style="margin-top: 15px; margin-bottom: 10px; background-size: cover"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between flex-wrap align-items-center">
                                        <button class="btn-purple-outline cancel">لغو</button>
                                        <button class="btn-purple update">به‌روزرسانی</button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php if (!$has_error && count($studios)) : ?>
                            <?php for ($i = 0; $i < count($studios); $i++) : ?>
                                <?php
                                $studio = $studios[$i];
                                $pictures_path = "";
                                $delim = '$%%$';
                                for ($i=0;$i<count($studio['pictures']);$i++){
                                    $pictures_path .= $studio['pictures'][$i]['path'] . $delim;
                                }
                                ?>
                                <tr data-id="<?php echo $studio['id']; ?>" data-pictures="<?php echo $pictures_path?>">
                                    <td>
                                        <div class="main__table-text main__table-text--number">
                                            <a href="javascript:void(0)"><?php echo $studio['id']; ?></a>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="switch s-success">
                                            <input type="checkbox" <?php echo $studio['is_active'] == 1 ? 'checked' : ''; ?>>
                                            <span class="sslider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="main__table-text font-weight-bold name"
                                             style="font-size: 14px;white-space: pre-wrap;word-break: break-word"><?php echo $studio['name']; ?></div>
                                    </td>
                                    <td>
                                        <div class="main__table-text city"
                                        data-id="<?php echo $studio['geographical_information']['city_id']; ?>"><?php echo $studio['geographical_information']['city']; ?></div>
                                    </td>
                                    <td>
                                        <div class="main__table-text main__table-text--price price"
                                             data-price="<?php echo $studio['price']; ?>"><?php echo format_price($studio['price']) ?></div>
                                        <span class="sr-only address"><?php echo $studio['address']; ?></span>
                                    </td>
                                    <td>
                                        <div class="main__table-text main__table-text--<?php echo strtolower($studio['status']) ?>">
                                            <?php switch ($studio['status']) :
                                                case 'APPROVAL' : ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M14.72,8.79l-4.29,4.3L8.78,11.44a1,1,0,1,0-1.41,1.41l2.35,2.36a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.29l5-5a1,1,0,0,0,0-1.42A1,1,0,0,0,14.72,8.79ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                                                    </svg>
                                                    تایید شده
                                                    <?php break; ?>
                                                <?php case 'PENDING' : ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20ZM14.09814,9.63379,13,10.26807V7a1,1,0,0,0-2,0v5a1.00025,1.00025,0,0,0,1.5.86621l2.59814-1.5a1.00016,1.00016,0,1,0-1-1.73242Z"></path>
                                                    </svg>
                                                    در انتظار تایید
                                                    <?php break; ?>
                                                <?php case 'FAILED' : ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M15.71,8.29a1,1,0,0,0-1.42,0L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L13.41,12l2.3-2.29A1,1,0,0,0,15.71,8.29Zm3.36-3.36A10,10,0,1,0,4.93,19.07,10,10,0,1,0,19.07,4.93ZM17.66,17.66A8,8,0,1,1,20,12,7.95,7.95,0,0,1,17.66,17.66Z"></path>
                                                    </svg>
                                                    تایید نشده
                                                    <?php break; ?>
                                                <?php endswitch; ?>
                                        </div>
                                    </td>
                                    <td class="table-control">
                                        <a href="javascript:void(0)" class="delete">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round" width="23"
                                                 class="text-danger">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </a>
<!--                                        <a href="javascript:void(0)" class="edit">-->
<!--                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
<!--                                                 viewBox="0 0 24 24"-->
<!--                                                 fill="none" stroke="currentColor" stroke-width="2"-->
<!--                                                 stroke-linecap="round"-->
<!--                                                 stroke-linejoin="round" class="text-secondary">-->
<!--                                                <circle cx="12" cy="12" r="10"></circle>-->
<!--                                                <polyline points="12 6 12 12 16 14"></polyline>-->
<!--                                            </svg>-->
<!--                                        </a>-->
                                        <a href="javascript:void(0)" class="edit">
                                            <svg width="24" height="24" viewBox="0 0 32 32"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#a0a0a0"
                                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!--            <div class="scrollbar-track scrollbar-track-x show" style="display: none;">-->
                <!--                <div class="scrollbar-thumb scrollbar-thumb-x"-->
                <!--                     style="width: 1136px; transform: translate3d(0px, 0px, 0px);"></div>-->
                <!--            </div>-->
                <!--            <div class="scrollbar-track scrollbar-track-y show" style="display: none;">-->
                <!--                <div class="scrollbar-thumb scrollbar-thumb-y"-->
                <!--                     style="height: 98px; transform: translate3d(0px, 0px, 0px);"></div>-->
                <!--            </div>-->
            </div>
        </div>
    <?php endif; ?>
    <div class="list-empty <?php echo count($studios) ? 'd-none' : ''; ?>">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="m16 6a1 1 0 0 1 0 2h-8a1 1 0 0 1 0-2zm7.707 17.707a1 1 0 0 1 -1.414 0l-2.407-2.407a4.457 4.457 0 0 1 -2.386.7 4.5 4.5 0 1 1 4.5-4.5 4.457 4.457 0 0 1 -.7 2.386l2.407 2.407a1 1 0 0 1 0 1.414zm-6.207-3.707a2.5 2.5 0 1 0 -2.5-2.5 2.5 2.5 0 0 0 2.5 2.5zm-4.5 2h-6a3 3 0 0 1 -3-3v-14a3 3 0 0 1 3-3h12a1 1 0 0 1 1 1v8a1 1 0 0 0 2 0v-8a3 3 0 0 0 -3-3h-12a5.006 5.006 0 0 0 -5 5v14a5.006 5.006 0 0 0 5 5h6a1 1 0 0 0 0-2z"></path>
        </svg>
        <p>گزینه ای برای نمایش وجود ندارد.</p>
    </div>

</div>