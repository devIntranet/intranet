<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Wniosek bez akceptacji";//temat maila

// w zmienn? $text_body wpisujemy tre?? maila
$text_body = "Zwr?ci?e? do poprawy wniosek o dost?p do danych osobowych z?o?ony przez $aduzytkownik2 <br>";
$text_body .= "dla pracownika $imie $nazwisko opatruj?c go uwag?: <br><br>";
$text_body .= "<i>$uwagawn.</i>";


$mail->Body = $text_body;
// adresat?w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia? NI");
$mail->AddAddress("informatyka@rpwik.tychy.pl","Dzia? NI");

if(!$mail->Send())
echo "B??d podczas wysy?ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";


// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys?ano <br>";


// w zmienn? $text_body wpisujemy tre?? maila
$text_body = "Dzia? Informatyki nie zaakceptowa? z?o?onego wniosku o dost?pu do danych osobowych<br>";
$text_body .= "dla pracownika $imie $nazwisko opatruj?c go uwag?:<br><br>";
$text_body .= "<i>$uwagawn</i>";


$mail->Body = $text_body;
// adresat?w dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia? NI");
$mail->AddAddress($aduzytkownikmail2, $aduzytkownik2);

if(!$mail->Send())
echo "B??d podczas wysy?ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys?ano <br>";

?>