<?php

include '../../config/config.php';

$post_data = $_POST;
$errors = array();
$updated_data = array();

if (array_key_exists('name',$post_data)){
    $update_result = callAPI('PUT', RAW_API.'studio/'.$post_data['studio_id'].'/name','name='.$post_data['name'],true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['name'][] = $update_result['messages'];
    }else{
        $updated_data['name'] = $update_result['name'];
    }
}


if (array_key_exists('price',$post_data)){
    $update_result = callAPI('PUT', RAW_API.'studio/'.$post_data['studio_id'].'/price','price='.$post_data['price'],true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['price'][] = $update_result['messages'];
    }else{
        $updated_data['price'] = $update_result['price'];
    }
}


if (array_key_exists('city',$post_data)){
    $update_result = callAPI('PUT', RAW_API.'studio/'.$post_data['studio_id'].'/city','city_id='.$post_data['city'],true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['city_name'][] = $update_result['messages'];
    }else{
        $updated_data['city'] = $update_result['city_id'];
    }
}


if (array_key_exists('address',$post_data)){
    $update_result = callAPI('PUT', RAW_API.'studio/'.$post_data['studio_id'].'/address','address='.$post_data['address'],true);
    $update_result = json_decode($update_result,true);
    if ($update_result['error']){
        $errors['address'][] = $update_result['messages'];
    }else{
        $updated_data['address'] = $update_result['address'];
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

if (count($errors)){
    echo json_encode([
        'error' => true,
        'messages' => $errors
    ]);
}else{
    echo json_encode([
        'error' => false,
        'data' => $updated_data
    ]);
}

?>