<?php global $user; ?>
<div id="confirmationCodeModal" class="modal">
    <div class="form-group">
        <label class="sign__label">کد یکبار مصرف</label>
        <input type="number" name="code" style="direction: ltr" autocomplete="off" placeholder="* * * * * *">
    </div>
    <div class="form-group text-left">
        <button type="button" class="btn-purple btn__confirm-code">تایید کد</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="dashbox">

            <div class="dashbox__title">
                <h3>اطلاعات شخصی</h3>
            </div>
            <div class="dashbox__list-wrap">
                <div class="row">

                    <div class="row col-12 mb-4 mx-auto px-0">
                        <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-3">
                            <div class="sign__group">
                                <label class="sign__label" for="userFirstName">نام</label>
                                <input id="userFirstName" type="text" autocomplete="off" name="first_name"
                                       data-current="<?php echo $user['data']['user']['first_name']; ?>"
                                       class="sign__input" value="<?php echo $user['data']['user']['first_name']; ?>"
                                       placeholder="باب">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-3">
                            <div class="sign__group">
                                <label class="sign__label" for="userLastName">نام خانوادگی</label>
                                <input id="userLastName" type="text" autocomplete="off" name="last_name"
                                       data-current="<?php echo $user['data']['user']['last_name']; ?>"
                                       class="sign__input" value="<?php echo $user['data']['user']['last_name']; ?>"
                                       placeholder="علوی">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-3">
                            <div class="sign__group">
                                <label class="sign__label" for="userEmailAddress">ایمیل</label>
                                <input id="userEmailAddress" type="email" autocomplete="off" name="email"
                                       data-current="<?php echo $user['data']['user']['email']; ?>"
                                       class="sign__input" value="<?php echo $user['data']['user']['email']; ?>"
                                       placeholder="someone@example.com">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-3">
                            <div class="sign__group">
                                <label class="sign__label" for="userMelliCode">کد ملی</label>
                                <input id="userMelliCode" type="text" name="melli_code" class="sign__input"
                                       data-current="<?php echo $user['data']['user']['melli_code']; ?>"
                                       value="<?php echo $user['data']['user']['melli_code']; ?>">
                            </div>
                        </div>

                        <!--                        visible only if user is artist -->
                        <?php if ($user['data']['is_artist']): ?>
                            <div class="col-12 is-artist-pending mt-3 mb-1">
                                <div class="n-chk is-advisor-description text-light">
                                    <label class="new-checkbox checkbox-outline-green">
                                        <input type="checkbox" class="new-control-input" name="is_advisor"
                                               <?php echo $user['data']['other_info']['artist']['is_advisor'] == '1' ? 'checked' : ''; ?>>
                                        <span class="new-control-indicator"></span>فعال کردن مشاوره
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12" id="AdvisorPriceContainer">
                                <div class="sign__group">
                                    <label class="sign__label" for="artistAdvisePrice">هزینه مشاوره</label>
                                    <input id="artistAdvisePrice" type="number" name="advise_price" class="sign__input"
                                           autocomplete="off"
                                           data-current="<?php echo $user['data']['other_info']['artist']['advise_price']; ?>"
                                           value="<?php echo $user['data']['other_info']['artist']['advise_price']; ?>"
                                           placeholder="هزینه ساعتی به تومان">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12" id="artistDeliveryTime">
                                <div class="sign__group">
                                    <label class="sign__label" for="artistDeliveryTime">مدت زمان تحویل</label>
                                    <input id="artistDeliveryTime" type="number" name="delivery_time" class="sign__input"
                                           autocomplete="off"
                                           data-current="<?php echo $user['data']['other_info']['artist']['delivery_time']; ?>"
                                           value="<?php echo $user['data']['other_info']['artist']['delivery_time']; ?>"
                                           placeholder="مثال: 6 روز">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="sign__group">
                                    <label class="sign__label">تجربیات</label>
                                    <textarea name="experience" class="sign__input" autocomplete="off" rows="4"
                                           data-current="<?php echo $user['data']['other_info']['artist']['experience']; ?>"><?php echo $user['data']['other_info']['artist']['experience']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="sign__group">
                                    <label class="sign__label">توضیحات سفارشات</label>
                                    <textarea name="order_description" class="sign__input" autocomplete="off" rows="4"
                                              data-current="<?php echo $user['data']['other_info']['artist']['order_description']; ?>"><?php echo $user['data']['other_info']['artist']['order_description']; ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <!--                                        <div class="row is-artist-container my-3">-->
            <!--                                            <div class="col-8 is-artist-description text-light">-->
            <!--                                                در صورتی که علاقه مند به دریافت پروژه هستید. گزینه مقابل را فعال کنید و-->
            <!--                                                رزومه-->
            <!--                                                خود را کامل کنید.-->
            <!--                                            </div>-->
            <!--                                            <div class="col-4 text-center">-->
            <!--                                                <label class="switch s-icons s-outline s-outline-success mr-2">-->
            <!--                                                    &lt;!&ndash; set to checked if user is artist &ndash;&gt;-->
            <!--                                                    <input type="checkbox" name="is_artist">-->
            <!--                                                    <span class="slider"></span>-->
            <!--                                                </label>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                        &lt;!&ndash; visible only if user is artist &ndash;&gt;-->
            <!--                                        <div class="row d-none is-artist-pending my-3">-->
            <!--                                            &lt;!&ndash;<div class="row">&ndash;&gt;-->
            <!--                                            <div class="col-8 is-advisor-description text-light">-->
            <!--                                                در صورت که مشاوره کاری به دیگران انجام میدهید گزینه مقابل را فعال کنید و-->
            <!--                                                هزینه مشاوره ساعتی را به تومان وارد کنید-->
            <!--                                            </div>-->
            <!--                                            <div class="col-4 text-center">-->
            <!--                                                <label class="switch s-icons s-outline s-outline-primary mr-2"-->
            <!--                                                       data-toggle="collapse" data-target="#AdvisorPriceContainer">-->
            <!--                                                    &lt;!&ndash; set to checked if user is artist &ndash;&gt;-->
            <!--                                                    <input type="checkbox" name="is_advisor">-->
            <!--                                                    <span class="slider"></span>-->
            <!--                                                </label>-->
            <!--                                            </div>-->
            <!--                                            &lt;!&ndash;</div>&ndash;&gt;-->
            <!--                                            <div class="col-12 collapse" id="AdvisorPriceContainer">-->
            <!--                                                <div class="sign__group mt-3">-->
            <!--                                                    <label class="sign__label" for="artistAdvisePrice">هزینه مشاوره</label>-->
            <!--                                                    <input id="artistAdvisePrice" type="text" name="advise_price"-->
            <!--                                                           class="sign__input" autocomplete="off"-->
            <!--                                                           placeholder="هزینه ساعتی به تومان">-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashbox">
            <div class="dashbox__title">
                <h3>شماره تماس</h3>
            </div>
            <div class="dashbox__list-wrap">
                <form class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="sign__label" for="currentMobile">تلفن همراه</label>
                            <input id="currentMobile" type="text" name="mobile" style="direction: ltr" autocomplete="off" placeholder="09*********">
                        </div>
                        <div class="form-group text-left">
                            <button type="button" class="btn-purple btn__change-mobile">ارسال کد</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="dashbox">
            <div class="dashbox__title">
                <h3>کذرواژه</h3>
            </div>
            <div class="dashbox__list-wrap">
                <form class="row">
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="sign__label" for="currentPassword">گذرواژه فعلی</label>
                            <input id="currentPassword" type="password" name="old_password">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="sign__label" for="newPassword">گذرواژه جدید</label>
                            <input id="newPassword" type="password" name="password">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="sign__label" for="newPasswordConfirmation">تکرار گذرواژه جدید</label>
                            <input id="newPasswordConfirmation" type="password" name="password_confirmation">
                        </div>
                    </div>
                    <div class="col-12 mb-1 text-left">
                        <div class="form-group">
                            <button type="submit" class="btn-purple btn__change-password">ثبت تغییرات</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--                                        <div class="row is-artist-container my-3">-->
            <!--                                            <div class="col-8 is-artist-description text-light">-->
            <!--                                                در صورتی که علاقه مند به دریافت پروژه هستید. گزینه مقابل را فعال کنید و-->
            <!--                                                رزومه-->
            <!--                                                خود را کامل کنید.-->
            <!--                                            </div>-->
            <!--                                            <div class="col-4 text-center">-->
            <!--                                                <label class="switch s-icons s-outline s-outline-success mr-2">-->
            <!--                                                    &lt;!&ndash; set to checked if user is artist &ndash;&gt;-->
            <!--                                                    <input type="checkbox" name="is_artist">-->
            <!--                                                    <span class="slider"></span>-->
            <!--                                                </label>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                        &lt;!&ndash; visible only if user is artist &ndash;&gt;-->
            <!--                                        <div class="row d-none is-artist-pending my-3">-->
            <!--                                            &lt;!&ndash;<div class="row">&ndash;&gt;-->
            <!--                                            <div class="col-8 is-advisor-description text-light">-->
            <!--                                                در صورت که مشاوره کاری به دیگران انجام میدهید گزینه مقابل را فعال کنید و-->
            <!--                                                هزینه مشاوره ساعتی را به تومان وارد کنید-->
            <!--                                            </div>-->
            <!--                                            <div class="col-4 text-center">-->
            <!--                                                <label class="switch s-icons s-outline s-outline-primary mr-2"-->
            <!--                                                       data-toggle="collapse" data-target="#AdvisorPriceContainer">-->
            <!--                                                    &lt;!&ndash; set to checked if user is artist &ndash;&gt;-->
            <!--                                                    <input type="checkbox" name="is_advisor">-->
            <!--                                                    <span class="slider"></span>-->
            <!--                                                </label>-->
            <!--                                            </div>-->
            <!--                                            &lt;!&ndash;</div>&ndash;&gt;-->
            <!--                                            <div class="col-12 collapse" id="AdvisorPriceContainer">-->
            <!--                                                <div class="sign__group mt-3">-->
            <!--                                                    <label class="sign__label" for="artistAdvisePrice">هزینه مشاوره</label>-->
            <!--                                                    <input id="artistAdvisePrice" type="text" name="advise_price"-->
            <!--                                                           class="sign__input" autocomplete="off"-->
            <!--                                                           placeholder="هزینه ساعتی به تومان">-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
        </div>
    </div>
</div>