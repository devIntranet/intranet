<?php
$mail = new PHPMailer();
date_default_timezone_set('Europe/Warsaw');
$mail->SMTPDebug = 1;
$mail->Port = 25;
$mail->PluginDir = "phpmailer/";
$mail->From = "informatyka@rpwiktychy.local"; //adres naszego konta
$mail->FromName = "System Powiadomień Działu FI";//nagłówek From
$mail->Host = "win-ex1";//adres serwera SMTP
$mail->Mailer = "smtp";
$mail->SMTPAuth = false;
$mail->SetLanguage("pl", "phpmailer/language/");
?>