<?php

require_once '../../../config/config.php';

if (isset($_POST['studio_id'])) {
    if ( $_POST['studio_id']>0 ) {
        $get_times = callAPI('GET', RAW_API . 'reservation/advisor', ['rpp' => 2000, 'id' => $_POST['studio_id']]);
        $get_times = json_decode($get_times, true);

        $times = array();
        if (!$get_times['error']) {
            $times = $get_times['dates']['data'];
        }
        $is_new = false;
    }else if ($_POST['studio_id']==='0'){
        $times = [];
        $is_new = true;
    }


    $get_allowed_hours = callAPI('GET', RAW_API . 'reservation/allowed/hrs', false);
    $allowed_hours = json_decode($get_allowed_hours, true);
    $allowed_hours = $allowed_hours['allowed_hours'];

    include 'accordion.php';
}
?>