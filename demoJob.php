<?php
#date_default_timezone_set("Europe/Berlin");

require_once 'src/cronLogClass.php';

$cron = new cronLogClass(__FILE__, $debug = TRUE);

$cron->log( "shit happens", 'error');
$cron->log($cron->get_config()->serverName);
$cron->log("omg");
$cron->log($cron->get_config()->pathToLockFolder, 'ok');

//$cron->log($cron->get_config()->pathToNoWhere, 1);
//echo $cron->get_config();


?>
