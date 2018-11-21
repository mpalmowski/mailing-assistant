<?php
session_start();
ini_set('max_execution_time', 0);
ini_set('display_errors', 'OFF');

include 'lib/conf.php';
include 'lib/database.php';
include 'lib/ssl.php';
include 'static/html/unsubscribe.html';

$conf = new Conf;
$database = new Database($conf);
$ssl = new Ssl($conf);

if(!isset($_GET['who']) || !isset($_GET['ctrl'])){
    error_log('Missing subscriber parameters');
    die();
}

$who = $_GET['who'];
$hash = $_GET['ctrl'];

$who = $ssl->decrypt($who);

if($ssl->hash($who) != $hash){
    $result = -1;
} else {
    $result = $database->removeSubscriber($who);
}

if($result == 1){
    $message = 'Nie będziesz już otrzymywał od nas informacji marketingowych.';
} else if ($result == 0) {
    $message = 'Twój adres nie znajduje się w naszej bazie danych.';
} else if ($result == -1) {
    $message = 'Wystąpił błąd';
}

echo "
<script>
    $('#unsubscribe_message').text('$message');
</script>
";

session_destroy();