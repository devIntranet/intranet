<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();

$mail->PluginDir = "phpmailer/";
$mail->From = "wnioski@rpwik.tychy.pl"; //adres naszego konta
$mail->FromName = "Wnioskobiorca";//nag³ówek From
$mail->Host = "192.168.1.94";//adres serwera SMTP
$mail->Mailer = "smtp";
$mail->Username = "seba";//nazwa u¿ytkownika
$mail->Password = "C0k0lwiek";//nasze has³o do konta SMTP
$mail->SMTPAuth = true;
$mail->SetLanguage("pl", "phpmailer/language/");

$mail->Subject = "Z³o¿ono nowy wniosek";//temat maila

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Siaki¶ kiep ($aduzytkownik) z³o¿y³ wnioskek  o dostêp do danych osobowych dla pracowjnika $imie $nazwisko\n\n";
$text_body .= "proponojê go odrzucic \n";
$text_body .= "uznaj±c za bezzasadny :-)";

$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress("seba@rpwik.tychy.pl","Dzia³ NI");

if(!$mail->Send())
echo "There has been a mail error <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
echo "Powiadomienie wys³ano <br>";

?>