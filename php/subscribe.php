<?php
include 'ssl.php';

$who = $_GET['who'];
$type = $_GET['type'];

$who = $ssl->decrypt($who);
$table = $type == "cust" ? "clients" : "distributors";

$existing = $database->select("e_mail", $table, "e_mail = '$who'");
$new_subscribent = false;
if($existing->num_rows == 0){
    $new_subscribent = true;
}

if($new_subscribent){
    $database->insert($table, "id, e_mail", "NULL, '$who'");
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
