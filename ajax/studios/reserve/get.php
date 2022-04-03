<?php

require_once '../../../config/config.php';

if (isset($_GET['itemId'])) {

    $cart_reserves=array();
    if (isset($_SESSION['cart'])){
        $cart_details = json_decode($_SESSION['cart'],true)['details'];
        $cart_reserves = array_column(array_values(array_filter($cart_details,function ($item){
            return $item['type']==='studio';
        })),'id');
    }

    $studioId = $_GET['itemId'];
    $itemIndex = isset($_GET['itemDate']) ? $_GET['itemDate'] : 0;
    $get_times = callAPI('GET', RAW_API . 'reservation/studio', ['rpp' => 100000, 'id' => $studioId]);
    $get_times = json_decode($get_times, true);
    if (!$get_times['error']) {
        $times = $get_times['dates']['data'];
        if (count($times)) {
            if (isset($_GET['itemDate'])){
                $current_time = array_values(array_filter($times,function ($time) use ($times){
                    return $time['shamsi_date_2']===$_GET['itemDate'];
                }))[0];
            }else{
                $current_time = $times[0];
            }
            if (count($current_time['details'])) {
                $current_time_details = $current_time['details'];
                echo "<ul class='reserve__times-list'>";
                for ($j = 0; $j < count($current_time_details); $j++) : ?>
                    <?php if (!$current_time_details[$j]['is_reserve']) : ?>
                        <li class="reserve__time-badge <?php echo in_array($current_time_details[$j]['id'],$cart_reserves) ? ' selected' : '';?>">
                            <a href="javascript:void(0)" data-id="<?php echo $current_time_details[$j]['id']; ?>">
                                <?php echo $current_time_details[$j]['allowed_hour']['started_at'] . ' تا ' . $current_time_details[$j]['allowed_hour']['ended_at']; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor;
                echo "</ul>";
            }
        }
    }
}

?>