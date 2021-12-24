<?php

require_once "../../config/config.php";
if (isset($_SESSION['access_token'])) {
    if (isset($_POST['type']) && isset($_POST['itemId'])) {
        if (in_array($_POST['type'], ['package', 'studio', 'advisor', 'teammate'])) {
            $cart_result = callAPI('DELETE', RAW_API . 'cart/' . $_POST['type'] . '?itemId=' . $_POST['itemId'], false, true);
            echo $cart_result;
        } else {
            echo json_encode([
                'error' => true,
                'messages' => [
                    'مورد انتخابی صحیح نمیباشد'
                ]
            ]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'messages' => [
                'مورد انتخابی صحیح نمیباشد'
            ]
        ]);
    }
} else {
    echo json_encode([
        'error' => true,
        'messages' => [
            'اول در حساب کاربری خود وارد شوید'
        ]
    ]);
}
?>