<?php
include 'ssl.php';
$who = "";
$type = "";
if(isset($_GET['who']))
    $who = $_GET['who'];
if(isset($_GET['type']))
    $type = $_GET['type'];

$existing = $database->select("*", $conf->get('db_subscribers_table'), "EMail = '$who' AND SubscriberType = '$type'");
$new_subscriber = false;
if($existing->num_rows == 0){
    $new_subscriber = true;
}

if($new_subscriber){
    $database->insert($conf->get('db_subscribers_table'), "ID, EMail, SubscriberType", "NULL, '$who', '$type'");
}

if($new_subscriber){
    $message = 'Thank you for subscribing';
} else {
    $message = 'You have already subscribed for our newsletter';
}

?>
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
