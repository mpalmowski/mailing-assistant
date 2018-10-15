<?php
include '../lib/conf.php';
include '../lib/sender.php';
include '../lib/ssl.php';

$subject = "";
$message = "";
if(isset($_POST['subject']))
    $subject = $_POST['subject'];
if(isset($_POST['message']))
    $message = $_POST['message'];

$conf = new Conf;
$sender = new Sender($conf);

if($sender->send($subject, $message, $conf->get('reply_address'), "", false))
    print("");
else
    print("Not sent");