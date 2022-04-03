<?php

require_once '../../config/config.php';

$get_buy = callAPI('GET', RAW_API.'buy', false, true);
$get_buy = json_decode($get_buy, true);
if (isset($get_buy['error']) && !$get_buy['error']){
    echo print_r($get_buy);
}else{
    echo json_encode($get_buy);
}

?>