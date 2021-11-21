<div class="col-12">
<div class="pagination-custom_outline">

    <a href="<?php echo $links[0]['url'] ?: 'javascript:void(0)' ?>" class="prev"
       style="cursor: <?php echo $links[0]['url'] ? 'pointer' : 'not-allowed' ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-chevron-right">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </a>

    <ul class="pagination">
        <?php for ($j = 1; $j < count($links) - 1; $j++) : ?>
            <li class="<?php echo $links[$j]['active'] ? 'active' : ''; ?>">
                <a href="<?php echo $links[$j]['active'] ? 'javascript:void(0)' : $links[$j]['url']; ?>">
                    <?php echo $links[$j]['label'] ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>

    <?php $lasti = count($links) - 1; ?>
    <a href="<?php echo $links[$lasti]['url'] ?: 'javascript:void(0)' ?>" class="next"
       style="cursor: <?php echo $links[$lasti]['url'] ? 'pointer' : 'not-allowed' ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-chevron-left">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </a>
</div>
</div>