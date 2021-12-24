<?php

global $user;

$get_cities = callAPI('GET',RAW_API.'cities',['rpp'=>2000]);
$get_cities = json_decode($get_cities,true);
$cities=array();
if (!($has_error = $get_cities['error']))
    $cities = $get_cities['cities']['data'];
//$allowed_hours = $allowed_hours['allowed_hours'];


//$get_allowed_hours = callAPI('GET',RAW_API.'reservation/allowed/hrs',false,false);
//$allowed_hours = json_decode($get_allowed_hours,true);
//$allowed_hours = $allowed_hours['allowed_hours'];
?>


<div class="dashbox">

    <div class="dashbox__title">
        <h3>افزودن استدیو</h3>
    </div>
    <div class="dashbox__list-wrap">
        <form id="formAddStudio" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 col-sm-10 mb-5">
                    <div class="custom-file-container" data-upload-id="studioImagesFileContainer">
                        <label class="sign__label">
                            آپلود عکس(ها)
                            <a href="javascript:void(0)" class="custom-file-container__image-clear" title="حذف همه">x</a>
                        </label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" name="images[]" accept="image/*"
                                   class="custom-file-container__custom-file__custom-file-input" multiple="">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                            <span class="custom-file-container__custom-file__custom-file-control">انتخاب کنید...
                                <span class="custom-file-container__custom-file__custom-file-control__button"> جست‌وجو </span>
                            </span>
                        </label>
                        <div class="custom-file-container__image-preview wide"
                             style="margin-top: 30px; margin-bottom: 10px;"></div>
                    </div>
                </div>
                <div class="row col-md-6 pl-md-0 pr-md-2 px-0 mx-auto">
                    <div class="col-md-12 mb-2">
                        <div class="sign__group">
                            <label class="sign__label" for="studioNameInput">نام استدیو</label>
                            <input id="studioNameInput" type="text" autocomplete="off" name="name" class="sign__input ">
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="sign__group">
                            <label class="sign__label" for="studioCity">شهر</label>
                            <input id="studioCity" type="text" class="sign__select" autocomplete="off">
                            <input id="studioCityID" type="hidden" name="city_id">
                            <ul class="list-group-flush list-group__cities"
                                style="max-height: 100px;z-index: 9999;position: absolute;left: 0;right: 0">
                                <?php if(!$has_error) : ?>
                                    <?php for($i=0;$i<count($cities);$i++) : ?>
                                        <li class="list-group-item bg-dark text-light d-none p-1"
                                            style="font-size: 13px;cursor: pointer"
                                            data-id="<?php echo $cities[$i]['id']; ?>">
                                            <?php echo $cities[$i]['name']; ?>
                                        </li>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </ul>
<!--                            </input>-->
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="sign__group">
                            <label class="sign__label" for="studioRentCostInput">هزینه اجاره</label>
                            <input id="studioRentCostInput" type="number" autocomplete="off"
                                   placeholder="69000" name="price" class="sign__input">
                            <p class="help-block">هزینه اجاره استدیو به ازای هر ساعت وارد کنید</p>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <div class="sign__group">
                            <label class="sign__label" for="studioGeoLocationTextArea">آدرس</label>
                            <textarea id="studioGeoLocationTextArea" rows="4" name="address"
                                      placeholder="آدرس دقیق استدیو را وارد کنید" class="sign__input"></textarea>
                        </div>
                    </div>

<!--                    <div class="row ml-0 mr-0">-->
<!--                        <h6 class="col-md-12">زمان های قابل رزرو استدیو</h6>-->
<!--                        <div class="d-flex flex-row flex-nowrap justify-content-start align-items-center px-3">-->
<!--                            <input type="text" name="allowed_date" placeholder="انتخاب تاریخ" autocomplete="off" class="ml-2">-->
<!--                            <select name="allowed_hour" class="ml-2">-->
<!--                                <option>-انتخاب کنید-</option>-->
<!--                                --><?php //for($i=0;$i<count($allowed_hours);$i++) : ?>
<!--                                    <option value="--><?php //echo $allowed_hours[$i]['id']; ?><!--">-->
<!--                                        --><?php //echo $allowed_hours[$i]['started_at'].' - '.$allowed_hours[$i]['ended_at'] ; ?>
<!--                                    </option>-->
<!--                                --><?php //endfor; ?>
<!--                            </select>-->
<!--                            <button type="button" class="btn-green-outline btn-add btn-add__allowed-hour" style="width: 42px"></button>-->
<!--                        </div>-->
<!--                        <table class="allowed_hours_list table mr-3 ml-3"></table>-->
<!--                    </div>-->


                    <!--                    <table class="table table-bordered" style="table-layout: fixed">-->
                    <!--                        <thead>-->
                    <!--                        <tr>-->
                    <!--                            <th style="width: 90px">-->
                    <!--                                <button onclick="addRow(event)" class="btn btn-sm btn-outline-success">-->
                    <!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">-->
                    <!--                                        <line x1="12" y1="5" x2="12" y2="19"></line>-->
                    <!--                                        <line x1="5" y1="12" x2="19" y2="12"></line>-->
                    <!--                                    </svg>-->
                    <!--                                </button>-->
                    <!--                            </th>-->
                    <!--                            <th style="width: 250px">نوع تمرین</th>-->
                    <!--                            <th style="width: 250px">ترتیب</th>-->
                    <!--                            <th style="width: 120px">ست</th>-->
                    <!--                            <th style="width: 175px">تکرار</th>-->
                    <!--                            <th style="width: 200px">ریتم</th>-->
                    <!--                            <th style="width: 200px">استراحت<span style="font-size: 10px">(ثانیه)</span></th>-->
                    <!--                            <th style="width: 300px">توضیحات</th>-->
                    <!--                        </tr>-->
                    <!--                        </thead>-->
                    <!--                        <tbody>-->
                    <!--                        </tbody>-->
                    <!--                    </table>-->

                    <div class="col-12 text-left">
                        <button type="submit" class="btn-green-outline btn-add px-4 py-2"> افزودن استدیو </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>