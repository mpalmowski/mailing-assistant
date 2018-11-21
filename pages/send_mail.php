<section>
    <div class="col h-100 justify-content-center flex-column d-flex">
        <div class="sending row w-100 justify-content-center mt-5">
            <h5>
                <?php
                echo _s("sending");
                ?>
            </h5>
        </div>
        <div class="progress">
            <div id="progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                 style="width: 0"></div>
        </div>
        <div class="row w-100 justify-content-center flex-row d-flex">
            <div class="small_message bg-light d-none">
                <h6 class="p-0 m-0 w-100 h-100 text-center" id="message">
                </h6>
            </div>
        </div>
    </div>
</section>
<?php
ob_flush();
flush();

$sender = new Sender($conf);

$subject = $_POST['subject'];
$message = $_POST['message'];
$send_mode = $_POST['send_mode'];
$addresses = $_POST['addresses'];

$addresses_array = array();

if($send_mode == "all")
    $addresses_array = $database->getSubscribersArray();
elseif ($send_mode == "manual")
    $addresses_array = explode(",", $addresses);

$errors = array();
$nr_of_messages = sizeof($addresses_array);
$messages_sent = 0;
$sent = array();
foreach ($addresses_array as $address) {
    $address = trim($address);

    if (!$sender->send($subject, $message, $address)) {
        array_push($errors, $address);
    } else {
        array_push($sent, $address);
    }

    $messages_sent++;
    $progress = ($messages_sent / $nr_of_messages) * 100;
    $progress = round($progress);
    echo "
    <script>
        var progress_bar = $('#progress_bar');
        progress_bar.css('width', '$progress%');
        progress_bar.text('$progress%');
    </script>
    ";
    ob_flush();
    flush();
}

$info = "";
if (count($errors)) {
    $info .= _s("message sending error");
    foreach ($errors as $error) {
        $info .= "<br>" . $error;
    }
} else
    $info .= _s("messages were sent");

echo "
<script>
    $('#message').html('$info');
    $('.progress, .sending').toggleClass('d-none');
    $('.small_message').toggleClass('d-none');
</script>
";
?>
