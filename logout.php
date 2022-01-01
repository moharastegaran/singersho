<?php
session_start();

unset($_SESSION['access_token'] );
unset($_SESSION['cart'] );
unset($_SESSION['artist_id'] );
header('Location:index.php');
die();

?>