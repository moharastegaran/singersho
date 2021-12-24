<?php
require_once '../../config/config.php';

parse_str(file_get_contents("php://input"), $input_data);

$update_studio = callAPI('PATCH', RAW_API.'studio/'.$input_data['studio_id'].'/activation',false,true);
echo $update_studio;
?>