<?php
require_once '../../config/config.php';

$params = isset($_GET['params']) ? $_GET['params'] : "";
$params = query_string_to_array($params,['rpp'=>12]);

$get_studios = callAPI('GET', RAW_API . 'studios',$params);
$studios = json_decode($get_studios, true);
$data = $studios['studios']['data'];
$links = $studios['studios']['links'];
for ($i = 0; $i < count($data); $i++) : ?>
    <div class="col-lg-4 col-md-4 col-sm-6 px-xl-1 px-0">
        <?php $studio = $data[$i]; ?>
        <?php include '../../views/cards/studio.php' ?>
    </div>
<?php endfor;

include '../../views/cards/pagination.php';

?>