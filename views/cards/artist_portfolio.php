<li class="portfolio-list-item" data-id="<?php echo $portfolio['id']; ?>">
    <div class="col-12">
        <img src="<?php echo (isset($portfolio['image']) && $portfolio['image']!==null) ? $portfolio['image'] : 'assets/img/studio-placeholder.png'; ?>" class="image">

        <a class="delete" href="javascript:void(0);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
        </a>
        <a href="javascript:void(0);" class="edit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
        </a>

        <h4 class="name"><?php echo $portfolio['name']; ?></h4>
        <p class="date"><?php echo $portfolio['date']; ?></p>

        <span class="sr-only url"><?php echo $portfolio['url']; ?></span>

    </div>
    <div class="col-12">
        <p class="description"><?php echo $portfolio['description']; ?></p>
    </div>
</li>