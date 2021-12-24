<?php

require '../../config/config.php';

$data = array();
if (is_uploaded_file($_FILES['singing_file']['tmp_name']))
    $data['singing_file'] = curl_file_create($_FILES['singing_file']['tmp_name']);

$singing_test = callAPI('POST',RAW_API.'singing',$data,true);
//$singing_result = json_decode($singing_test,true);
echo $singing_test;

?>