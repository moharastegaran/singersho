<?php

require_once '../../../config/config.php';

if (isset($_POST['date']) && isset($_POST['time'])) {

//    $current_dates = array();
//    if (!isset($_POST['time'])){
//        $get_current_dates = callAPI('GET', RAW_API . 'reservation/advisor', ['rpp' => 1200, 'id' => $_SESSION['artist_id']]);
//        $get_current_dates = json_decode($get_current_dates, true);
//        if (!$get_current_dates['error']) {
//            $current_dates = $get_current_dates['dates']['data'];
//        }
//        $current_dates = array_map(function ($item){
//            return $item['shamsi_date_2'];
//        },$current_dates);
//    }
//
//    if (in_array($_POST['date'],$current_dates)){
//        echo json_encode([
//            'error'=>true,
//            'messages'=>['تاریخ قبلا ثبت نشده است']
//        ]);
//        die();
//    }

    $date = $_POST['date'];
    $times = $_POST['time'];
    $add_datetime = callAPI('PUT', RAW_API . 'reservation/advisor?date=' . $date . "&time=" . $times, false, true);
    echo $add_datetime;
}else{
    echo json_encode([
        'error' => true,
        'messages' => ['ورودی اشتباه است']
    ]);
}