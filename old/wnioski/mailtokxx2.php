<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Poprawiono wniosek";//temat maila

// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Poprawi�e(a)� wniosek  o dost�p do danych osobowych dla pracownika $wniosek[imie] $wniosek[nazwisko] <br><br>";
$text_body .= "Wniosek oczekuje na akceptacj� dzia�u NI przed wys�aniem go do dzia�u NK";


$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress($aduzytkownikmail, $aduzytkownik);

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";


// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "$aduzytkownik poprawi� wniosek  o dost�p do danych osobowych dla pracownika $wniosek[imie] $wniosek[nazwisko]<br><br>";
$text_body .= "Wniosek oczekuje na akceptacj� dzia�u NI przed wys�aniem go do dzia�u NK";


$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress("informatyka@rpwik.tychy.pl","Dzia� NI");

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";


?>