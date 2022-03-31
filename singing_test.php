<?php

include 'header.php';
?>

<div class="container-fluid mx-auto">
    <div class="container mb-lg-5 pb-lg-4">
        <div class="row align-items-center my-5">
            <div class="col-md-6 mb-md-1 mb-5">
                <div class="about-img">
                    <img src="assets/img/mikrofon-makro.jpg">
                </div>
            </div>
            <div class="col-md-6">
                <div class="thead">
                    <h3 class="thead-sub">تست خوانندگی رایگان</h3>
                    <h2 class="thead-main">تست صدا</span></h2>
                    <p class="thead-description">
                        می خوای تست خوانندگی بدی؟
                        ثبت نام در تست خوانندگی آکادمی ساز و صدا بسیار ساده است.
                        <br>
                        <br>
                        در ادامه مطلب روش ثبت نام در تست صدا رو کامل توضیح داده ایم.
                    </p>
                </div>
                <ul class="listicon">
                    <li class="listicon-item">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="0 0 507.506 507.506" style="enable-background:new 0 0 507.506 507.506;"
                             xml:space="preserve" width="48" height="48">
                        <g>
                            <path d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"></path>
                        </g>
                    </svg>
                        <span>ضبط صدای خود با کیفیت</span>
                    </li>
                    <li class="listicon-item">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="0 0 507.506 507.506" style="enable-background:new 0 0 507.506 507.506;"
                             xml:space="preserve" width="48" height="48">
                        <g>
                            <path d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"></path>
                        </g>
                    </svg>
                        <span>ارسال فایل صوتی از طریق ایم  قسمت</span>
                    </li>
                    <li class="listicon-item">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="0 0 507.506 507.506" style="enable-background:new 0 0 507.506 507.506;"
                             xml:space="preserve" width="48" height="48">
                        <g>
                            <path d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"></path>
                        </g>
                    </svg>
                        <span>در انتظار پاسخ پشتیبان سایت برای بررسی فایل</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="my-lg-5 my-md-3 d-lg-block d-none"></div>
    </div>
    <div class="row mt-md-5 mt-3 py-lg-5 px-lg-5"
         style="background: url(assets/img/icons/wave-dark.svg) bottom left no-repeat;background-size: cover">
        <div class="col-md-6">
            <h2 class="header-x4large">
                صدایتان را برای ما بفرستید
            </h2>
        </div>
        <div class="col-md-6 text-center">
            <form id="singing__test-form" method="post" action="ajax/singing/send.php" enctype="multipart/form-data"
                  class="text-center mb-md-5 mb-4">
                <div class="col-md-12">
                    <div class="file-upload-wrapper">
                        <div class="view file-upload">
                            <input type="file" name="singing_file" accept="audio/*" id="audiofile" class="file_upload">
                            <p class="file-upload-infos-message">فایل صوتی را به این بخش بکشید یا انتخاب کنید</p>
                        </div>
                    </div>
                </div>
                <div class="player d-none">
                    <div class="audio-progress">
                        <input id="timeslieder" class="timeslieder" type="range" value="0" min="0" max="100"
                               step="0.001"/>
                        <div class="time d-flex justify-content-around" style="width:100%;">
                            <span id="duration">00:00:00</span>
                            <div id="reset" class="control-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g id="_01_align_center" data-name="01 align center">
                                        <path d="M22,12a10.034,10.034,0,1,1-2.878-7H15V7h5.143A1.859,1.859,0,0,0,22,5.143V0H20V3.078A11.985,11.985,0,1,0,24,12Z"/>
                                    </g>
                                </svg>
                            </div>
                            <div id="pause" class="control-icon d-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M6.5,0A3.5,3.5,0,0,0,3,3.5v17a3.5,3.5,0,0,0,7,0V3.5A3.5,3.5,0,0,0,6.5,0Z"/>
                                    <path d="M17.5,0A3.5,3.5,0,0,0,14,3.5v17a3.5,3.5,0,0,0,7,0V3.5A3.5,3.5,0,0,0,17.5,0Z"/>
                                </svg>
                            </div>
                            <div id="start" class="control-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M20.492,7.969,10.954.975A5,5,0,0,0,3,5.005V19a4.994,4.994,0,0,0,7.954,4.03l9.538-6.994a5,5,0,0,0,0-8.062Z"/>
                                </svg>
                            </div>
                            <span id="currentTime" style="width: 52px">00:00:00</span>
                        </div>
                    </div>
                </div>
                <audio id="track" src="" type="audio/mp3"></audio>
                <button class="btn__submit-singing-test hvr-grow-rotate mt-5" data-ripple="">ارسال</button>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
