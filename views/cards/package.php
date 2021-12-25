<div class="product package" data-id="<?php echo $package['id']; ?>">
    <div class="product__cover single" style="background-image: url(<?php echo $package['image']; ?>)">
        <!--                            <a href="#"><i class="icofont-shopping-cart"></i> میخرمش-->
        <!--                            </a>-->
        <span class="product__stat">
                                <span><i class="fas fa-cloud-download-alt"></i> <span class="number">0</span> خرید</span>
                                <span><i class="fas fa-users"></i> <span class="number"><?php echo count($package['members']); ?></span> عضو</span>
                            </span>
    </div>
    <h3 class="product__title"><a href="package.php?id=<?php echo $package['id']; ?>"><?php echo $package['name']; ?></a></h3>
    <span class="product__price"><span class="number"><?php echo format_price($package['price']); ?></span> تومان</span>
    <a href="javascript:void(0)" data-id="<?php echo $package['id']; ?>"
       class="product__<?php echo ((isset($package['in_cart']) && $package['in_cart']) ? 'deletefrom' : 'addto')?>-basket hvr-float-shadow">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <circle cx="7" cy="22" r="2"/>
            <circle cx="17" cy="22" r="2"/>
            <path d="M23,3H21V1a1,1,0,0,0-2,0V3H17a1,1,0,0,0,0,2h2V7a1,1,0,0,0,2,0V5h2a1,1,0,0,0,0-2Z"
            <?php if(isset($package['in_cart']) && $package['in_cart']): ?>
            style="transform: rotate(45deg) translate(-10%,-60%)"
            <?php endif; ?>/>
            <path d="M21.771,9.726a.994.994,0,0,0-1.162.806A3,3,0,0,1,17.657,13H5.418l-.94-8H13a1,1,0,0,0,0-2H4.242L4.2,2.648A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.829-2H17.657a5,5,0,0,0,4.921-4.112A1,1,0,0,0,21.771,9.726Z"/>
        </svg>
    </a>
</div>