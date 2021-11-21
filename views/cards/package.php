<div class="product" data-id="<?php echo $package['id']; ?>">
    <div class="product__cover single" style="background-image: url(<?php echo $package['image']; ?>)">
        <!--                            <a href="#"><i class="icofont-shopping-cart"></i> میخرمش-->
        <!--                            </a>-->
        <span class="product__stat">
                                <span><i class="fas fa-cloud-download-alt"></i> <span class="number">0</span> خرید</span>
                                <span><i class="fas fa-users"></i> <span class="number"><?php echo count($package['members']); ?></span> عضو</span>
                            </span>
    </div>
    <h3 class="product__title"><a href="#"><?php echo $package['name']; ?></a></h3>
    <span class="product__price"><span class="number"><?php echo format_price($package['price']); ?></span> تومان</span>
    <a href="javascript:void(0)" class="product__addto-basket hvr-float-shadow"><img src="assets/img/icons/shopping-cart-add.svg"></a>
</div>