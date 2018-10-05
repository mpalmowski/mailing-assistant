<?php
include 'ssl.php';
include 'database.php';
include 'conf.php';

$who = $_GET['who'];
$type = $_GET['type'];

$who = $ssl->decrypt($who);
$table = $type == "cust" ? "clients" : "distributors";

$conf->load();

$db = $database->connect($conf->params['db_servername'], $conf->params['db_username'], $conf->params['db_password'], $conf->params['db_name']);

$existing = $db->query("SELECT e_mail FROM $table WHERE e_mail = '$who'");
$new_subscribent = false;
if($existing->num_rows == 0){
    $new_subscribent = true;
}

if($new_subscribent){
    $db->query("INSERT INTO $table (id, e_mail) VALUES (NULL, '$who')");
}

if($new_subscribent){
    $message = 'Thank you for subscribing';
} else {
    $message = 'You have already subscribed for our newsletter';
}

?>
<section>
    <div class="col h-100 justify-content-center flex-column d-flex">
        <div class="row w-100 justify-content-center flex-row d-flex">
            <img class="mt-4" src="http://www.nocai.info/wp-content/uploads/2018/09/NOCAI-LOGO-200.png">
        </div>
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
