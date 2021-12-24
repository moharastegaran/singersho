<?php

include '../../config/config.php';

$post_data = $_POST;
$errors = array();

if (array_key_exists('name',$post_data)){
    $update_result = callAPI('POST', RAW_API.'studio/'.$post_data['studio_id'].'/name',array(['name'=>$post_data['name']]),true);
    echo print_r($update_result);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['name'][] = $update_result['messages'];
    }
}


if (array_key_exists('price',$post_data)){
    $update_result = callAPI('POST', RAW_API.'studio/'.$post_data['studio_id'].'/price',array(['price'=>$post_data['price']]),true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['price'][] = $update_result['messages'];
    }
}


if (array_key_exists('city',$post_data)){
    $update_result = callAPI('POST', RAW_API.'studio/'.$post_data['studio_id'].'/city',array(['city_id'=>$post_data['city']]),true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['city_name'][] = $update_result['messages'];
    }
}


if (array_key_exists('address',$post_data)){
    $update_result = callAPI('POST', RAW_API.'studio/'.$post_data['studio_id'].'/address',array(['address'=>$post_data['address']]),true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['address'][] = $update_result['messages'];
    }
}

if (array_key_exists('images',$_FILES)){
    $fileCount = count($_FILES['images']['name']);
    for($i=0;$i<$fileCount;$i++){
        $image = curl_file_create($_FILES['images']['tmp_name'][$i]);
        $resultt=callAPI('POST',RAW_API.'studio/'.$post_data['studio_id'].'/image',['image' => $image,],true);
        $resultt = json_decode($resultt,true);
//            if ($resultt['error'])
//                $errors = array_merge($errors,$resultt['messages']);
    }
}

?>