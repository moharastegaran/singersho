<?php

require_once '../../../config/config.php';

if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['studioId'])) {

    $date = $_POST['date'];
    $times = $_POST['time'];
    $studioId = $_POST['studioId'];
    $add_datetime = callAPI('PUT', RAW_API . 'reservation/studio?date=' . $date . "&time=" . $times . "&studioId=" . $studioId, false, true);
    echo $add_datetime;
}else{
    echo json_encode([
        'error' => true,
        'messages' => ['ورودی اشتباه است']
    ]);
}