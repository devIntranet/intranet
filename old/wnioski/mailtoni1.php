<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Potwierdzono wniosek";//temat maila

// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Zatwierdzi�e� wniosek o dost�p do danych osobowych z�o�ony przez $aduzytkownik2 <br><br>";
$text_body .= "dla pracownika $imie $nazwisko";


$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress("informatyka@rpwik.tychy.pl","Dzia� NI");

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia<br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";


// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "Dzia� Informatyki zaakceptowa� z�o�ony wniosek dost�pu do danych osobowych<br>";
$text_body .= "dla pracownika $imie $nazwisko <br><br>";
$text_body .= "Wniosek oczekuje na pisemne akceptacje.";


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


// w zmienn� $text_body wpisujemy tre�� maila
$text_body = "$aduzytkownik2 z�o�y� wniosek o dost�p do danych osobowych RPWiK<br>";
$text_body .= "dla pracownika $imie $nazwisko. <br><br>";
$text_body .= "Upowa�nienie oczekuje na twojej karcie nowych wniosk�w.";


$mail->Body = $text_body;
// adresat�w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia� NI");
$mail->AddAddress("kadry@rpwik.tychy.pl", "Dzia� Kadr");

if(!$mail->Send())
echo "B��d podczas wysy�ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys�ano <br>";


?>