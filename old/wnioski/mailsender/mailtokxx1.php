<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();

$mail->PluginDir = "phpmailer/";
$mail->From = "wnioski@rpwik.tychy.pl"; //adres naszego konta
$mail->FromName = "Wnioskobiorca";//nag��wek From
$mail->Host = "192.168.1.94";//adres serwera SMTP
$mail->Mailer = "smtp";
$mail->Username = "seba";//nazwa u�ytkownika
$mail->Password = "C0k0lwiek";//nasze has�o do konta SMTP
$mail->SMTPAuth = true;
$mail->SetLanguage("pl", "phpmailer/language/");

$mail->Subject = "Z�o�ono nowy wniosek";//temat maila

// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Siaki� kiep ($aduzytkownik) z�o�y� wnioskek  o dost�p do danych osobowych dla pracowjnika $imie $nazwisko\n\n";
$text_body .= "proponoj� go odrzucic \n";
$text_body .= "uznaj�c za bezzasadny :-)";

$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress("seba@rpwik.tychy.pl","Dzia� NI");

if(!$mail->Send())
echo "There has been a mail error <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
echo "Powiadomienie wys�ano <br>";

?>