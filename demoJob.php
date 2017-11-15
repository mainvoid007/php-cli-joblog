<?php
date_default_timezone_set("Europe/Berlin");

require_once 'src/cronLogClass.php';

$cron = new cronLogClass(__FILE__, $debug = TRUE);

$cron->log( "shit happens", 0);
$cron->log($cron->get_config()->get_serverName(), 1);
$cron->log("omg");
$cron->log($cron->get_config()->get_pathToLockFolder(), 1);



?>
