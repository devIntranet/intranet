<?php
$mail = new PHPMailer();

$mail->SMTPDebug = 1;
$mail->Port = 25;
$mail->PluginDir = "phpmailer/";
$mail->From = "idp@rpwik.tychy.pl"; //adres naszego konta
$mail->FromName = "System Obs³ugi Wniosków";//nag³ówek From
$mail->Host = "exchange1";//adres serwera SMTP
$mail->Mailer = "smtp";
$mail->Username = "seba";//nazwa u¿ytkownika
$mail->Password = "C0k0lwiek";//nasze has³o do konta SMTP
$mail->SMTPAuth = false;
$mail->SetLanguage("pl", "phpmailer/language/");
?>