<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Potwierdzono wniosek";//temat maila

// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Usun��e� wniosek o dost�p do danych osobowych z�o�ony przez $aduzytkownik2 <br><br>";
$text_body .= "dla pracownika $imie $nazwisko";


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


// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Dzia� Informatyki usun�� z�o�ony wniosek dost�pu do danych osobowych<br>";
$text_body .= "dla pracownika $imie $nazwisko <br><br>";



$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress($aduzytkownikmail2, $aduzytkownik2);

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";

?>