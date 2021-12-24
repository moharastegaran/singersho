<?php

require_once '../config/config.php';
$data = array();
if (isset($_FILES['avatar'])) {
    $data['avatar'] = curl_file_create($_FILES['avatar']['tmp_name']);
    $user_update = callAPI('POST', RAW_API . 'avatar', $data, true);
} else if (isset($_POST['password'])) {
    $data = $_POST;
    $user_update = callAPI('POST', RAW_API . 'password', $data, true);
} else {
    if ($_POST['name'] === 'accept_advisor')
        $data = array();
    else
        $data = [$_POST['name'] => $_POST['value']];
    $user_update = callAPI('POST', RAW_API . $_POST['name'], $data, true);
}
echo $user_update;

?>