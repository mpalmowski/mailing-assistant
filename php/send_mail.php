<section>
    <div class="col h-100 justify-content-center flex-column d-flex">
        <div class="row w-100 justify-content-center flex-row d-flex">
            <img class="mt-4" src="http://www.nocai.info/wp-content/uploads/2018/09/NOCAI-LOGO-200.png">
        </div>
        <div class="sending row w-100 justify-content-center mt-5">
            <h5>Wysyłanie</h5>
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
include 'ssl.php';
ob_flush();
flush();

$mail_regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

$sender_name = $conf->params['sender_name'];
$sender_address = $conf->params['sender_address'];
$reply_address = $conf->params['reply_address'];
$recipient_type = $_POST['recipient_type'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$addresses = $_POST['addresses'];

$addresses_array = explode(",", $addresses);

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $sender_name . "<" . $sender_address . ">" . "\r\n";
$headers .= "Reply-To: " . $reply_address . "\r\n";

$errors = array();
$nr_of_messages = sizeof($addresses_array);
$messages_sent = 0;
$sent = array();
foreach ($addresses_array as $address) {
    $address = trim($address);

    if (!strlen($address)) {
        continue;
    } else if (!preg_match($mail_regex, $address)) {
        array_push($errors, $address);
    } else {
        $personal_message = str_replace("_insert_subscribe_link_",
            $conf->params['subscribe_link'],
            $message);
        $personal_message = str_replace("_insert_unsubscribe_link_",
            $conf->params['unsubscribe_link'],
            $personal_message);
        $result = mail($address, $subject, $personal_message, $headers);

        if (!$result) {
            array_push($errors, $address);
        } else {
            array_push($sent, $address);
        }
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
