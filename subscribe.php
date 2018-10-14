<?php
session_start();
ini_set('max_execution_time', 0);
ini_set('display_errors', 'OFF');

include 'lib/conf.php';
include 'lib/database.php';
include 'lib/ssl.php';

$conf = new Conf;
$database = new Database($conf);
$ssl = new Ssl($conf);

if(!isset($_GET['who']) || !isset($_GET['type'])){
    error_log('Missing subscriber parameters');
    die();
}

$who = $_GET['who'];
$type = $_GET['type'];

$who = $ssl->decrypt($who);
$type = $ssl->decrypt($type);

$result = $database->addSubscriber($who, $type);

if($result == 1){
    $message = 'Thank you for subscribing';
} else if ($result == 0) {
    $message = 'You have already subscribed for our newsletter';
} else if ($result == -1) {
    $message = 'An error occured';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Mailing Assistant</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link href='static/css/bootstrap.min.css' rel='stylesheet'>
    <link href='static/css/main.css' rel='stylesheet'>
    <script src='static/js/jquery-3.3.1.js'></script>
    <script src='static/js/popper.js'></script>
</head>
<body>
<section>
    <div class="col h-100 justify-content-center flex-column d-flex">
        <div class="row w-100 justify-content-center flex-row d-flex">
            <div class="small_message bg-white">
                <h4 class="p-0 m-0 w-100 h-100 text-center">
                    <?php
                    echo $message;
                    ?>
                </h4>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<?php
session_destroy();
