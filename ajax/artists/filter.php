<?php
require_once '../../config/config.php';

$params = isset($_GET['params']) ? $_GET['params'] : "";
$params = query_string_to_array($params,['rpp'=>12]);

$get_artists = callAPI('GET', RAW_API . 'artists',$params);
$artists = json_decode($get_artists, true);
$data = $artists['artists']['data'];
$links = $artists['artists']['links'];
for ($i = 0; $i < count($data); $i++) : ?>
    <div class="col-lg-3 col-md-4 col-sm-6 px-0">
        <?php $artist = $data[$i]; ?>
        <?php include '../../views/cards/artist.php' ?>
    </div>
<?php endfor;

    include '../../views/cards/pagination.php';

?>