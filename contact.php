<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $data = $_POST;
    $contact_result = callAPI('POST',RAW_API.'contact_us',$data);
    $contact_result = json_decode($contact_result,true);
}

?>

    <img src="assets/img/striped-half-circle.png" style="position: absolute;left: 0;top: 10%;max-width: 80%">

    <div class="container-fluid mx-auto">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-center py-5">
                <div class="contact-box">
                    <img src="assets/img/icons/envelope.svg" class="contact-img">
                    <div class="contact-content">
                        <h3>ایمیل:</h3>
                        <p>info@singersho.com</p>
                    </div>
                </div>
                <div class="contact-box">
                    <img src="assets/img/icons/phone-call-2.svg" class="contact-img">
                    <div class="contact-content">
                        <h3>تلفن تماس:</h3>
                        <p>
                            +98 21 88732542
                            <br>
                            +98 912 309 4047
                        </p>
                    </div>
                </div>
                <div class="contact-box">
                    <img src="assets/img/icons/map-marker.svg" class="contact-img">
                    <div class="contact-content">
                        <h3>آدرس دفتر:</h3>
                        <p>تهران، شریعتی، پایینتر از سیدخندان، نبش کوچه جهاد، پلاک ۸۳۸</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center my-md-5 my-1">
                <div class="col-sm-6">
                    <div class="contact-img">
                        <img src="assets/img/contact.jpg">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="thead">
                        <h3 class="thead-sub">تماس باما</h3>
                        <h2 class="thead-main">ارتباط با <span class="thead-highlight">ساز و صدا</span></h2>
                        <p class="thead-description">
                            <br>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        </p>
                    </div>
                    <div class="w-100">
                        <form method="post" class="contact-form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <input type="text" class="contact-form-input" placeholder="نام*"
                                               value="<?php echo isset($contact_result['error']) && $contact_result['error'] ? $data['full_name'] : null; ?>"
                                               autocomplete="off" name="full_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <input type="email" class="contact-form-input" placeholder="ایمیل*"
                                               value="<?php echo isset($contact_result['error']) && $contact_result['error'] ? $data['email'] : null; ?>"
                                               autocomplete="off" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="contact-input-group">
                                <input type="text" class="contact-form-input" placeholder="موضوع" autocomplete="off"
                                       value="<?php echo isset($contact_result['error']) && $contact_result['error'] ? $data['subject'] : null; ?>"
                                       name="subject">
                            </div>
                            <div class="contact-input-group">
                                <textarea class="contact-form-input" placeholder="توضیحات*" name="description" rows="5"><?php echo isset($contact_result['error']) && $contact_result['error'] ? $data['description'] : null; ?></textarea>
                            </div>
                            <button type="submit">
                                ارسال
                                <svg viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m4.5 8.5-4-4 4-4" fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" transform="translate(7 6)"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 mt-5 pt-5" style="filter: grayscale(.7)">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d960.5391500846223!2d51.44505345343346!3d35.73505296038675!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe4545a18820c67d3!2z2YTYp9uM2YjYp9iz2KrZiNiv24zZiDI0!5e0!3m2!1sen!2suk!4v1637417958422!5m2!1sen!2suk"
                height="350" style="border:0;width: 100%" allowfullscreen="" loading="lazy"></iframe>
    </div>

<?php
include 'footer.php';
if (isset($contact_result['error'])) : ?>
<script>
    Snackbar.show({
        text: "<?php echo $contact_result['messages'][0]; ?>",
        showAction: false,
        pos: 'top-right <?php echo $contact_result['error'] ? 'danger' : ''; ?>',
        duration: <?php echo $contact_result['error'] ? 3000 : 6000; ?>
    });
</script>
<?php endif; ?>