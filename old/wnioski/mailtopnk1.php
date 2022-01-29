<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Wniosek w trakcie odwo³ywania";//temat maila

$loginy=mysql_db_query("ewidencja", "select * from wnioski 
left join uzytkownicy
on uzytkownicy.id_u = wnioski.id_u
where wnioski.id_wn = '$idwn' ");
$ile_login=mysql_num_rows($loginy);
$dane=mysql_fetch_array($loginy);
$dane_imie=$dane['imie'];
$dane_nazwisko=$dane['nazwisko'];
$dane_loginad_u=$dane['loginad_u'];
$filtr3 = "(sAMAccountName=$dane_loginad_u)";
$wyjatki3 = array("department", "title", "sAMAccountName", "displayname", "mail");
$czytaj3 = ldap_search($ldapconn, $base_dn, $filtr3, $wyjatki3);
$wpis3 = ldap_get_entries($ldapconn, $czytaj3);
$aduzytkownik3 = $wpis3[0]['displayname'][0];
$aduzytkownikmail3 = $wpis3[0]['mail'][0];
$isologin = $wpis3[0]['displayname'][0];
$aduzytkownik3 = iconv('UTF-8', 'ISO-8859-2', $isologin);

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Dzia³ Kadr z³o¿y³ wniosek o odwo³anie upowa¿nienia <br><br>";
$text_body .= "dla pracownika $dane_imie $dane_nazwisko";


$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'

$mail->AddAddress("kadry@rpwik.tychy.pl", "Dzia³ NK");
if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";
$mail->ClearAddresses();
$mail->ClearAttachments();

$mail->AddAddress($aduzytkownikmail3, $aduzytkownik3);
if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";
$mail->ClearAddresses();
$mail->ClearAttachments();

$mail->AddAddress("informatyka@rpwik.tychy.pl", "Dzia³ NI");
if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";
$mail->ClearAddresses();
$mail->ClearAttachments();



?>