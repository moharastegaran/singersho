<?php
require_once '../../config/config.php';

$params = isset($_GET['params']) ? $_GET['params'] : "";
$params = query_string_to_array($params,['rpp'=>12]);

$get_packages = callAPI('GET', RAW_API . 'packages',$params);
$packages = json_decode($get_packages, true);
$data = $packages['packages']['data'];
$links = $packages['packages']['links'];
for ($i = 0; $i < count($data); $i++) : ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <?php $package = $data[$i]; ?>
        <?php include '../../views/cards/package.php' ?>
    </div>
<?php endfor;

include '../../views/cards/pagination.php';

?>