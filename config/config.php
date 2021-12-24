<?php
session_start();

const RAW_API = 'http://127.0.0.1:8000/api/';

function callAPI($method, $url, $data, $hasToken = false)
{
    $curl = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PATCH":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        case "GET":
            if ($data) {
                $url = sprintf('%s?%s', $url, urldecode(http_build_query($data)));
            }
    }
    if ($hasToken && isset($_SESSION['access_token'])) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $_SESSION['access_token']]);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    $result = curl_exec($curl);
    if (!$result) {
        die(curl_error($curl));
//        die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}

function query_string_to_array($params, $appended = [])
{
    $params = explode('&', $params);
    $temp = null;
    $result = $appended;
    for ($i = 0; $i < count($params); $i++) {
        $temp = explode('=', $params[$i]);
        if (count($temp) === 2 && $temp[0] !== null)
            $result[$temp[0]] = $temp[1];
    }
    return $result;
}


function format_price($price)
{
    $formated = "";
    $reminder = strlen($price) % 3;
    $formated = substr($price, 0, $reminder);
    for ($i = $reminder; $i < strlen($price); $i += 3) {
        $formated = $formated . ($i === $reminder && $reminder === 0 ? "" : ",") . substr($price, $i, 3);
    }
    return $formated;
}

?>