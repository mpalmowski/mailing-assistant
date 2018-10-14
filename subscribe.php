<?php
session_start();
ini_set('max_execution_time', 0);
ini_set('display_errors', 'OFF');

include 'lib/conf.php';
include 'lib/database.php';
include 'lib/ssl.php';

$conf = new Conf;
$database = new Database($conf);

$who = "";
$type = "";
if(isset($_GET['who']))
    $who = $_GET['who'];
if(isset($_GET['type']))
    $type = $_GET['type'];

$new_subscriber = !$database->subscriberExists($who, $type);

if($new_subscriber){
    $database->addSubscriber($who, $type);
}

if($new_subscriber){
    $message = 'Thank you for subscribing';
} else {
    $message = 'You have already subscribed for our newsletter';
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
            <div class="small_message bg-light">
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
