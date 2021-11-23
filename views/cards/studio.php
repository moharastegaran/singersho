<div class="studio">
    <div class="studio__cover <?php if(count($studio['pictures'])<1) echo 'blank-background'; ?>"
         style="background-image: url(<?php echo count($studio['pictures'])>0 ? $studio['pictures'][0]['path'] : 'assets/img/studio-placeholder.png'?>)">
        <a href="studios.php" class="studio__location-badge"
           data-id="<?php echo $studio['geographical_information']['city_id']?>">
            <?php echo $studio['geographical_information']['city']?>
        </a>
    </div>
    <div class="studio__content">
        <span class="studio__price"><?php echo format_price($studio['price']); ?></span>
        <h3 class="studio__title"><a href="javascript:void(0)"><?php echo $studio['name']; ?></a></h3>
        <p class="studio__description">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25Z"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M12 1.25C12.4142 1.25 12.75 1.58579 12.75 2V3.28169C16.9842 3.64113 20.3589 7.01581 20.7183 11.25H22C22.4142 11.25 22.75 11.5858 22.75 12C22.75 12.4142 22.4142 12.75 22 12.75H20.7183C20.3589 16.9842 16.9842 20.3589 12.75 20.7183V22C12.75 22.4142 12.4142 22.75 12 22.75C11.5858 22.75 11.25 22.4142 11.25 22V20.7183C7.01581 20.3589 3.64113 16.9842 3.28169 12.75H2C1.58579 12.75 1.25 12.4142 1.25 12C1.25 11.5858 1.58579 11.25 2 11.25H3.28169C3.64113 7.01581 7.01581 3.64113 11.25 3.28169V2C11.25 1.58579 11.5858 1.25 12 1.25ZM4.75 12C4.75 16.0041 7.99594 19.25 12 19.25C16.0041 19.25 19.25 16.0041 19.25 12C19.25 7.99594 16.0041 4.75 12 4.75C7.99594 4.75 4.75 7.99594 4.75 12Z"/>
            </svg>
            <span><?php echo $studio['address'] ?></span>
        </p>
    </div>
</div>