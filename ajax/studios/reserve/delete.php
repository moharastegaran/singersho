<?php

require_once '../../../config/config.php';

if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['studioId'])){

    $date = $_POST['date'];
    $time = $_POST['time'];
    $studioId = $_POST['studioId'];
    $delete_datetime = callAPI('DELETE',RAW_API.'reservation/studio?date='.$date."&time=".$time. "&studioId=". $studioId,false,true);
    echo $delete_datetime;
}