<?php
session_start();
ini_set('max_execution_time', 0);
ini_set('display_errors', 'OFF');
ini_set('log_errors', 1);
ini_set('error_log', 'php.log');

$known_pages = ['main', 'send_mail', 'show_base', 'settings'];

$page = $known_pages[0];
if(isset($_GET['pg'])){
    $pg = $_GET['pg'];
	if (in_array($pg, $known_pages)) {
		$page = $pg;
	}
}
$pginc = "pages/$page.php";

include 'lib/conf.php';
include 'lib/database.php';
include 'lib/i18n.php';
include 'lib/ssl.php';
include 'lib/sender.php';

$conf = new Conf;

$_SESSION['lang'] = $conf->get('language');

$database = new Database($conf);
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

<?php include 'pages/header.php'; ?>

<?php include "$pginc"; ?>

<?php include 'pages/footer.php'; ?>

<script src='static/js/bootstrap.min.js'></script>

</body>

</html>

<?php
session_destroy();