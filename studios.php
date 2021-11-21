<?php

include 'header.php';
require_once 'config/config.php';

$params = isset($_GET['params']) ? $_GET['params'] : $_SERVER['QUERY_STRING'];
$params = query_string_to_array($params, ['rpp' => 12]);

$get_artists = callAPI('GET', RAW_API . 'studios', $params);
$artists = json_decode($get_artists, true);
$data = $artists['studios']['data'];
$links = $artists['studios']['links'];
?>
<div id="list__main-container" class="container mx-auto">
    <div class="row">
        <?php for($i = 0; $i < count($data); $i++) : ?>
            <div class="col-lg-4 col-md-4 col-sm-6 px-0">
                <?php $studio = $data[$i]; ?>
                <?php include 'views/cards/studio.php' ?>
            </div>
        <?php endfor; ?>

<!--        --><?php //include 'views/cards/pagination.php' ?>
    </div>
</div>
<?php include 'footer.php';
