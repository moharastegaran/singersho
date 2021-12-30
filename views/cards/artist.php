<div class="artist">
    <div class="artist__cover single" style="background-image: url(<?php echo $artist['avatar'] ?>)">
        <!--                    <a href="#"> مشاهده-->
        <!--                        <i class="icofont-eye-alt"></i>-->
        <!--                    </a>-->
        <?php if (array_key_exists('titles', $artist) && count($artist['titles'])) : ?>
            <div class="artist__stat">
                <?php for ($k = 0; $k < count($artist['titles']); $k++) : ?>
                    <a href="artists.php" class="artist__badge"
                       data-title="<?php echo $artist['titles'][$k]['name']; ?>">
                        <?php echo $artist['titles'][$k]['name']; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="artist__title text-muted">
        <h3>
            <a href="artist.php?id=<?php echo $artist['id']; ?>"><?php echo $artist['first_name'] . ' ' . $artist['last_name'] ?></a>
        </h3>
        <?php if (array_key_exists('is_advisor', $artist)): ?>
            <?php if ($artist['is_advisor'] === 0) : ?>
                <span> مشاوره نمیدهد</span>
            <?php else : ?>
                <span> مشاوره ساعتی : <num class="number"><?php echo format_price($artist['advise_price']) ?></num> تومان</span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>