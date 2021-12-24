<?php
require_once '../../config/config.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST' :

        $data = $_POST;
        if (array_key_exists('portfolio_id', $data)) {
            $update_portfolio = callAPI('POST', RAW_API . 'portfolio/artist/edit/' . $data['portfolio_id'], $data, true);
            echo $update_portfolio;
        } else {
            if (is_uploaded_file($_FILES['image']['tmp_name']))
                $data['image'] = curl_file_create($_FILES['image']['tmp_name']);
            $get_portfolio = callAPI('POST', RAW_API . 'portfolio/artist', $data, true);
            $artist_portfolio = json_decode($get_portfolio, true);
            if (!$artist_portfolio['error']) {
                $portfolio = $artist_portfolio['portfolio'][0];
                include '../../views/cards/artist_portfolio.php';
            } else {
                echo "<div class='alert alert-outline-danger'>";
                for ($i = 0; $i < count($artist_portfolio['messages']); $i++) {
                    echo $artist_portfolio['messages'][$i];
                    if ($i !== count($artist_portfolio['messages']) - 1)
                        echo "<br>";
                }
                echo "</div>";
            }
        }
        break;

//    case 'PATCH' :
//        parse_str(file_get_contents("php://input"), $input_data);
//        echo print_r($input_data);
//        $update_portfolio = callAPI('PATCH', RAW_API . 'portfolio/artist/edit/' . $input_data['portfolio_id'],$input_data, true);
//        $update_result = json_decode($update_portfolio, true);
//        echo print_r($update_result);
//        if(!$update_result['error']){
//            echo json_encode($update_result['portfolio'][0]);
//        }
//        break;

    case 'DELETE' :
        parse_str(file_get_contents("php://input"), $input_data);
        $delete_portfolio = callAPI('DELETE', RAW_API . 'portfolio/artist/' . $input_data['item_id'], false, true);
        $delete_result = json_decode($delete_portfolio, true);
        if (!$delete_result['error']) {
            for ($i = 0; $i < count($delete_result['messages']); $i++) {
//
            }
        }
        break;

}
