<?php
session_start();
$remote_user = $_SERVER['REMOTE_USER'];
$auth_user = $_SERVER['USER_AUTH'];
$logon_user = $_SERVER['LOGON_USER'];
echo $remote_user;
#list($domena, $user) = explode("\\", $remote_user);
$remote_address = $_SERVER['REMOTE_ADDR'];
print_r($_SERVER);

echo $auth_user;
echo $remote_address;
echo $logon_user;
echo $remote_user;
#echo $domena;
#echo $user;

?>