<?php
require_once '../../config/config.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST' :
        $get_title = callAPI('POST', RAW_API . 'title/artist', $_POST, true);
        $artist_title = json_decode($get_title, true);
        $has_error = $artist_title['error'];
        if (!$has_error) {
            $artist_title = $artist_title['new_title'];
            $artist_title['id'] = $artist_title['title_id'];
            $artist_title['name'] = $_POST['title_text'];
            include '../../views/cards/artist_title.php';
        } else {
            echo "<div class='alert alert-outline-danger fade show'>";
            for ($i = 0; $i < count($artist_title['messages']); $i++) {
                echo $artist_title['messages'][$i];
                if ($i !== count($artist_title['messages']) - 1)
                    echo "<br>";
            }
            echo '<button type="button" class="close" data-dismiss="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>';
            echo "</div>";
        }
        break;

    case 'PATCH' :
        parse_str(file_get_contents("php://input"), $input_data);
        $update_title = callAPI('PATCH', RAW_API . 'title/artist/edit/' . $input_data['title_id'],$input_data, true);
        $update_result = json_decode($update_title, true);
        if(!$update_result['error']){
            echo json_encode($update_result['title']);
        }
        break;

    case 'DELETE' :
        parse_str(file_get_contents("php://input"), $input_data);
        $delete_title = callAPI('DELETE', RAW_API . 'title/artist/' . $input_data['item_id'], false, true);
        $delete_result = json_decode($delete_title, true);
        if (!$delete_result['error']) {
            for ($i = 0; $i < count($delete_result['messages']); $i++) {
//
            }
        }
        break;

}
