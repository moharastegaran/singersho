<?php

include 'header.php';

$get_user = callAPI('GET', RAW_API . 'me', false, true);
$user = json_decode($get_user, true);
$username = $user['data']['user']['first_name'] . ' ' . $user['data']['user']['last_name'];
$usermobile = $user['data']['user']['mobile'];
if ($user['data']['is_artist'] && !isset($_SESSION['artist_id']))
    $_SESSION['artist_id'] = $user['data']['other_info']['artist']['id']
?>

    <div class="container-fluid">
        <div class="row mt-md-5 mt-3">
            <div class="col-lg-3">
                <div class="profile-box">
                    <div class="profile-box__section">
                        <div class="profile-box__header">
                            <?php if ($user['data']['is_artist']): ?>
                                <?php $avatar = $user['data']['other_info']['artist']['avatar']; ?>
                                <!--                                     href="--><?php //echo $user['data']['other_info']['artist']['avatar'] ?><!--"-->
                                <div class="profile-box__avatar"
                                     style="background-image: url(<?php echo isset($avatar) ? $avatar : 'https://www.digikala.com/static/files/fd4840b2.svg' ?>)">
                                    <div class="profile-box__avatar-overlay <?php echo !isset($avatar) ? 'd-none' : ''; ?>"
                                         href="<?php echo isset($avatar) ? $avatar : 'javascript:void(0);'; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M23.707,22.293l-5.969-5.969a10.016,10.016,0,1,0-1.414,1.414l5.969,5.969a1,1,0,0,0,1.414-1.414ZM10,18a8,8,0,1,1,8-8A8.009,8.009,0,0,1,10,18Z"/>
                                            <path d="M13,9H11V7A1,1,0,0,0,9,7V9H7a1,1,0,0,0,0,2H9v2a1,1,0,0,0,2,0V11h2a1,1,0,0,0,0-2Z"/>
                                        </svg>
                                    </div>
                                    <a class="profile-edit__avatar">
                                        <input type="file" name="avatar" accept="image/*">
                                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"/>
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="profile-box__header-content">
                                <div class="profile-box__username">
                                    <?php if ($user['data']['other_info']['artist']['is_advisor'] == 1): ?>
                                    <a href="artist.php?id=<?php echo $user['data']['other_info']['artist']['id'] ?>"
                                       target="_blank">
                                        <?php endif; ?>
                                        <?php echo $username; ?>
                                        <?php if ($user['data']['other_info']['artist']['is_advisor'] == 1): ?>
                                    </a>
                                <?php endif; ?>
                                </div>
                                <div class="profile-box__phone"><?php echo $usermobile; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-box__section">
                        <?php $hash = isset($_GET['p']) ? $_GET['p'] : 'main' ?>
                        <ul class="profile-menu">
                            <li>
                                <a href="javascript:void(0)" data-target="#main"
                                   class="profile-menu__item profile-menu__item-myinfo <?php echo $hash === 'main' ? 'active' : '' ?>">
                                    پروفایل من
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" data-target="#edit-account"
                                   class="profile-menu__item profile-menu__item-editinfo <?php echo $hash === 'edit-account' ? 'active' : '' ?> ">
                                    ویرایش اطلاعات
                                </a>
                            </li>
                            <li class="<?php echo $user['data']['other_info']['artist']['is_advisor'] == 1 ? '' : 'd-none'; ?>">
                                <a href="javascript:void(0)" data-target="#advisor-times"
                                   class="profile-menu__item profile-menu__item-advisortimes <?php echo $hash === 'advisor-times' ? 'active' : '' ?> ">
                                    زمان‌های مشاوره
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" data-target="#add-studio"
                                   class="profile-menu__item profile-menu__item-addstudio <?php echo $hash === 'add-studio' ? 'active' : '' ?>">افزودن
                                    استدیو</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" data-target="#my-studios"
                                   class="profile-menu__item profile-menu__item-mystudios <?php echo $hash === 'my-studios' ? 'active' : '' ?>">
                                    استدیوهای من
                                </a>
                            </li>
                            <li><a href="#" class="profile-menu__item profile-menu__item-myorders">سفارش‌های من</a></li>
                            <li><a href="logout.php" class="profile-menu__item profile-menu__item-logout">خروج</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="profile-container">
                    <?php global $user; ?>
                    <?php include 'views/profile/' . (isset($_GET['p']) ? $_GET['p'] : 'main') . '.php'; ?>
                </div>
            </div>
        </div>
    </div>

<?php
include 'footer.php';
