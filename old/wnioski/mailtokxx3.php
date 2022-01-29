<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$danewniosku=mysql_db_query("ewidencja", "select wnioski.imie, wnioski.nazwisko, uzytkownicy.imie_u, uzytkownicy.nazwa_u, uzytkownicy.loginad_u 
from wnioski 
left join uzytkownicy 
on uzytkownicy.id_u = wnioski.id_u
where wnioski.id_wn = '$idwn' ");
$wyswietl_dane = mysql_fetch_array($danewniosku);
$imie = $wyswietl_dane[imie];
$nazwisko = $wyswietl_dane[nazwisko];
$user2 = $wyswietl_dane[loginad_u];
$filtr2 = "(sAMAccountName=$user2)";
$wyjatki2 = array("department", "title", "sAMAccountName", "displayname", "mail");
$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
$aduzytkownik2 = $wpis2[0]['displayname'][0];
$aduzytkownikmail2 = $wpis2[0]['mail'][0];
$isologin = $wpis2[0]['displayname'][0];
$aduzytkownik2 = iconv('UTF-8', 'ISO-8859-2', $isologin);

$mail->IsHTML(true);
$mail->Subject = "Odwo³anie wniosku";//temat maila

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Z³o¿y³e(a)¶ wniosek o odwo³anie upowa¿neinia do przetwarzania danych osobowych dla pracownika $wyswietl_dane[imie] $wyswietl_dane[nazwisko] <br><br>";
$text_body .= "Wniosek oczekuje na uzupe³nienie przez dzia³ NK";


$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress($aduzytkownikmail2, $aduzytkownik2);

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";


// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "$aduzytkownik2 z³o¿y³ wniosek  o odwo³anie upowa¿neinia do przetwarzania danych osobowych dla pracownika $wyswietl_dane[imie] $wyswietl_dane[nazwisko] <br><br>";
$text_body .= "Wniosek oczekuje na twojej karcie nowych wniosków";


$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress("kadry@rpwik.tychy.pl","Dzia³ NK");

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "$aduzytkownik2 z³o¿y³ wniosek  o odwo³anie upowa¿neinia do przetwarzania danych osobowych dla pracownika $wyswietl_dane[imie] $wyswietl_dane[nazwisko] <br><br>";
$text_body .= "Wniosek oczekuje na usupe³nienie przez dzia³ NK";


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