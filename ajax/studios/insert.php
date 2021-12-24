<?php

require_once '../../config/config.php';

$insert_studio = callAPI('POST', RAW_API . 'studio/register', $_POST, true);
$insert_result = json_decode($insert_studio, true);
if (!$insert_result['error']) {
    $studioID = $insert_result['studio']['id'];
    $image = null;
    if (array_key_exists('images',$_FILES)){
        $fileCount = count($_FILES['images']['name']);
        for($i=0;$i<$fileCount;$i++){
            $image = curl_file_create($_FILES['images']['tmp_name'][$i]);
            $resultt=callAPI('POST',RAW_API.'studio/'.$studioID.'/image',['image' => $image,],true);
            $resultt = json_decode($resultt,true);
//            if ($resultt['error'])
//                $errors = array_merge($errors,$resultt['messages']);
        }
    }
    echo json_encode(['error'=>false,'redirect'=>'profile.php?p=my-studios']);
}else{
//    echo "<div class='alert alert-outline-danger fade show'>";
    echo $insert_studio;
//    $errors = $insert_result['messages'];
//    for ($i = 0; $i < count($errors); $i++) {
//        echo $errors[$i];
//        if ($i !== count($errors) - 1) echo "<br>";
//    }
//    echo '<button type="button" class="close" data-dismiss="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>';
//    echo "</div>";
}
?>