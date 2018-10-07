<?php
session_start();

$known_pages = ['main', 'send_mail', 'subscribe', 'show_base', 'settings'];
$languages = ['pl', 'en'];

$page = $known_pages[0];
if(isset($_GET['pg'])){
    $pg = $_GET['pg'];
	if (in_array($pg, $known_pages)) {
		$page = $pg;
	}
}
$pginc = "php/$page.php";

$language = $languages[0];
if(isset($_GET['lang'])){
    $lang = $_GET['lang'];
    if (in_array($lang, $languages)) {
        $language = $lang;
    }
}
$_SESSION['lang'] = $language;

include 'php/i18n.php';
include 'php/conf.php';
include 'php/database.php';

$database = new Database($conf->params['db_servername'], $conf->params['db_username'], $conf->params['db_password'], $conf->params['db_name']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Mailing Assistant</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link href='css/bootstrap.min.css' rel='stylesheet'>
    <link href='css/main.css' rel='stylesheet'>
    <script src='js/jquery-3.3.1.js'></script>
    <script src='js/popper.js'></script>
</head>

<body>

<?php include 'php/header.php'; ?>

<?php include "$pginc"; ?>

<?php include 'php/footer.php'; ?>

<script src='js/bootstrap.min.js'></script>

</body>

</html>

<?php
session_destroy();