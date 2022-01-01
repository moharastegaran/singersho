<?php

require_once '../../../config/config.php';

if (isset($_POST['date']) && isset($_POST['time'])){

    $date = $_POST['date'];
    $time = $_POST['time'];
    $delete_datetime = callAPI('DELETE',RAW_API.'reservation/advisor?date='.$date."&time=".$time,false,true);
    echo $delete_datetime;
}