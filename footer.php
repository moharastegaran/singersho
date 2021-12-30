</main>

<footer class="<?php if (strpos($current_url, 'index.php') !== false) { ?> line-background <?php } ?>">
    <div class="d-flex flex-row flex-wrap align-items-start justify-content-around">
        <div class="col-md-4 col-sm-6 text-right">
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
        <div class="col-md-4 col-sm-6 text-sm-right text-center">
            <p class="text">
                تمامی حقوق این سایت متعلق به شرکت سازوصدا می باشد.
            </p>
        </div>
        <div class="col-md-4 col-sm-6 text-sm-left text-center">
            <ul>
                <li><a href="#">شرایط و ضوابط</a></li>
                <li><a href="about.php">درباره ما</a></li>
            </ul>
        </div>
    </div>
</footer>

<!-- back to top -->
<!--<div class="aux-goto-top-btn">-->
<!--    <div class="aux-arrow-nav">-->
<!--        <span class="aux-overlay"></span>-->
<!--        <span class="aux-svg-arrow"></span>-->
<!--        <span class="aux-hover-arrow aux-svg-arrow aux-white"></span>-->
<!--    </div>-->
<!--</div>-->

</div>

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

<?php if (strpos($page_name, 'profile') === false) : ?>

    <script src="assets/js/crange-slider.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!--<script src="assets/js/jquery.nice-select.min.js"></script>-->
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/select2-custom.min.js"></script>
    <script src="assets/js/main.js"></script>

<?php else : ?>

    <script src="assets/js/file-upload-with-preview.min.js"></script>
    <script src="assets/js/bootstrap-maxlength.js"></script>
    <script src="assets/js/custom-bs-maxlength.js"></script>
    <script src="assets/js/persian-datepicker.min.js"></script>
    <script src="assets/js/profile.js"></script>

<?php endif; ?>
</body>
</html>