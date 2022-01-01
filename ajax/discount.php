<?php

require_once '../config/config.php';

if (isset($_GET['code'])){
    $check_discount = callAPI('GET',RAW_API.'discount/check',['code'=>$_GET['code']],true);
    echo $check_discount;
}