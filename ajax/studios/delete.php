<?php
require_once '../../config/config.php';

parse_str(file_get_contents("php://input"), $input_data);

$delete_studio = callAPI('DELETE',RAW_API.'studio/'.$input_data['studio_id'],false,true);
//echo RAW_API.'studio/'.$input_data['studio_id'];
echo $delete_studio;
?>