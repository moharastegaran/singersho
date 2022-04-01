</main>

<footer class="<?php echo strpos($current_url, 'index.php') !== false ? 'line-background' : '' ?>">
    <div class="d-flex flex-row flex-wrap align-items-start justify-content-around">
        <div class="col-md-4 mb-md-0 mb-4 text-right">
            <a href="index.php" class="logo"><img src="assets/img/logo.png" height="35"></a>
            <p class="text">
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و
                متون
                بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای
                متنوع
                با هدف بهبود ابزارهای کاربردی می باشد.
            </p>
        </div>
        <div class="col-md-4 col-sm-6 mt-sm-0 mt-4">
            <h4>دسترسی سریع</h4>
            <ul class="list-group-flush footer-links">
                <?php global $page_name; ?>
                <li class="list-group-item <?php if (strpos($page_name, 'index') !== false) {
                    echo 'active';
                } ?> ?>">
                    <a href="index.php" class="text-white">خانه</a>
                </li>
                <li class="list-group-item <?php if (strpos($page_name, 'artists') !== false) {
                    echo 'active';
                } ?>">
                    <a href="artists.php" class="text-white">هنرمندان</a>
                </li>
                <li class="list-group-item <?php if (strpos($page_name, 'store') !== false) {
                    echo 'active';
                } ?>">
                    <a href="store.php" class="text-white">فروشگاه</a>
                </li>
                <li class="list-group-item <?php if (strpos($page_name, 'studios') !== false) {
                    echo 'active';
                } ?>">
                    <a href="studios.php" class="text-white">استدیوها</a>
                </li>
            </ul>
        </div>
        <div class="col-md-4 col-sm-6 mt-sm-0 mt-4">
            <h4>اطلاعات تماس</h4>
            <ul class="list-group-flush">
                <li class="list-group-item border-bottom-0">
                    <!--<strong><i class="fas fa-map-marker-alt"></i> آدرس ما:</strong>-->تهران،
                    شریعتی، پایینتر از سیدخندان، نبش کوچه جهاد، پلاک ۸۳۸
                </li>
                <li class="list-group-item border-bottom-0"><strong><i class="fas fa-envelope"></i> ایمیل:</strong>info@singersho.com
                </li>
                <li class="list-group-item border-bottom-0"><strong><i class="fas fa-phone"></i> شماره تماس
                        <num class="number">1</num>
                        :</strong><span dir="ltr" class="number">+98 21 88732542</span>
                </li>
                <li class="list-group-item"><strong><i class="fas fa-phone"></i> شماره تماس
                        <num class="number">2</num>
                        :</strong><span dir="ltr" class="number">+98 912 309 4047</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <div class="col-md-6 col-sm-8 text-sm-right text-center">
            <p class="text">
                تمامی حقوق این سایت متعلق به شرکت سازوصدا می باشد.
            </p>
        </div>
        <div class="col-md-6 col-sm-4 text-sm-left text-center">
            <ul>
                <li class="<?php echo strpos($current_url, 'contact.php') !== false ? 'active' : '' ?>">
                    <a href="contact.php">شرایط و ضوابط</a></li>
                <li class="<?php echo strpos($current_url, 'about.php') !== false ? 'active' : '' ?>">
                    <a href="about.php">درباره ما</a></li>
            </ul>
        </div>
    </div>
</footer>


</div>


<?php if (strpos($current_url,'profile.php') === false ) : ?>

<div class="progress-wrap">
    <svg class="to-top-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M17.71,9.88l-4.3-4.29a2,2,0,0,0-2.82,0L6.29,9.88a1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0L11,8V19a1,1,0,0,0,2,0V8l3.29,3.29a1,1,0,1,0,1.42-1.41Z"/>
    </svg>
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>

<?php endif; ?>

<div id="mm-blocker"></div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<!--<script src="assets/js/jquery.nice-select.min.js"></script>-->
<script src="assets/js/jquery-ui.min.js"></script>
<!--<script src="assets/js/jquery.ui.touch-punch.min.js"></script>-->
<script src="assets/js/jquery.blockUi.min.js"></script>
<!--<script src="assets/js/TweenMax.min.js"></script>-->

<script src="assets/js/jquery.bez.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/snackbar.min.js"></script>
<script src="assets/js/magnific-popup.min.js"></script>

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/select2-custom.min.js"></script>

<script src="assets/js/global.js"></script>

<?php if (strpos($page_name, 'profile') === false) : ?>

    <script src="assets/js/crange-slider.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!--<script src="assets/js/jquery.nice-select.min.js"></script>-->
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script src="assets/js/main.js"></script>

<?php else : ?>

    <script src="assets/js/file-upload-with-preview.min.js"></script>
    <script src="assets/js/bootstrap-maxlength.js"></script>
    <script src="assets/js/custom-bs-maxlength.js"></script>
    <script src="assets/js/persian-datepicker.min.js"></script>
    <script src="assets/js/profile.js"></script>


<?php endif; ?>
<script>
    $(document).ready(function () {
        $('a[href="#mm-menu"]').on('click', function (e) {
            e.preventDefault();
            // $('html').addClass('mm-opening');
            $('#mm-menu').css({'display': 'block'});
            setTimeout(function () {
                $('#mm-menu').addClass('mm-opened');
                $('#mm-0').addClass('is-opening');
                $('#mm-blocker').addClass('dblock is-opening');
                $('html').addClass('overflow-hidden');
            }, 100);
        });

        $('#mm-blocker').on('click', function (e) {
            e.preventDefault();
            // $('html').removeClass('mm-opening');
            $('#mm-menu').removeClass('mm-opened is-opening');
            $('#mm-0').removeClass('is-opening');
            $('html').removeClass('overflow-hidden');
            setTimeout(function () {
                $('#mm-blocker').removeClass('dblock is-opening')
            }, 400);
        });
    })
</script>
</body>
</html>