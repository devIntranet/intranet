<?php
//phpinfo();

require("PHPMailer-FE_v4.1/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Temat testowy";//temat maila

// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Test tresci";



$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress("dariuszm@rpwiktychy.local","Sebastian Jurka");

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia<br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";

//echo "Powiadomienie wys�ano <br>";


?>