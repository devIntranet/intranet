<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Z³o¿ono nowy wniosek";//temat maila

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Z³o¿y³e(a)¶ wniosek  o dostêp do danych osobowych dla pracownika $imie $nazwisko<br><br>";
$text_body .= "Wniosek oczekuje na akceptacjê dzia³u NI przed wys³aniem go do dzia³u NK";


$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress($aduzytkownikmail, $aduzytkownik);

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";


// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "$aduzytkownik z³o¿y³ wniosek  o dostêp do danych osobowych dla pracownika $imie $nazwisko <br><br>";
$text_body .= "Wniosek oczekuje na akceptacjê dzia³u NI przed wys³aniem go do dzia³u NK";


$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress("informatyka@rpwik.tychy.pl","Dzia³ NI");

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";


?>