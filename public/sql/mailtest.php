<?php
//phpinfo();

require("PHPMailer-FE_v4.1/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Temat testowy";//temat maila

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Test tresci";



$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress("dariuszm@rpwiktychy.local","Sebastian Jurka");

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia<br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";

//echo "Powiadomienie wys³ano <br>";


?>