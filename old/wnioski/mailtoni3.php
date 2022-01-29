<?php
//phpinfo();

require("phpmailer/class.phpmailer.php");
require("mailconnauth.php");

$mail->IsHTML(true);
$mail->Subject = "Upowa¿nienie gotowe";//temat maila

$loginy=mysql_db_query("ewidencja", "select * from wnioski
left join uprawnienia
on wnioski.id_wn = uprawnienia.id_wn
left join moduly
on uprawnienia.id_mod = moduly.id_mod
left join systemy
on systemy.id_sys = moduly.id_sys
where wnioski.id_wn = '$idwnpost'
and uprawnienia.login_mod != ''
and uprawnienia.haslo_mod != '' ");
$ile_login=mysql_num_rows($loginy);

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Zamkn±³e¶ wniosek o dostêp do danych osobowych z³o¿ony przez $aduzytkownik2 <br>";
$text_body .= "dla pracownika $imie $nazwisko <br><br>";

if ($ile_login > 0)
	{
	$text_body .= "Dodatkowe informacje:<br>";
	$text_body .= "<table border=1><tr>";	
	$text_body .= "<td><b>Nazwa Systemu</b></td>";
	$text_body .= "<td><b>Nazwa Modu³u</b></td>";
	$text_body .= "<td><b>Login</b></td>";
	$text_body .= "<td><b>Pocz±tkowe has³o</b></td>";
	$text_body .= "</tr>";
	}
for($i = 0; $i < $ile_login; $i++)
	{
		
	$loginpass=mysql_fetch_array($loginy);
	$text_body .= "<tr>";
	$text_body .= "<td>$loginpass[nazwa_sys]</td>";
	$text_body .= "<td>$loginpass[nazwa_mod]</td>";
	$text_body .= "<td>$loginpass[login_mod]</td>";
	$text_body .= "<td>$loginpass[haslo_mod]</td>";
	$text_body .= "</tr>";
	}
if ($ile_login > 0)
	{
	$text_body .= "</table>";
	}	

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



$loginy2=mysql_db_query("ewidencja", "select * from wnioski
left join uprawnienia
on wnioski.id_wn = uprawnienia.id_wn
left join moduly
on uprawnienia.id_mod = moduly.id_mod
left join systemy
on systemy.id_sys = moduly.id_sys
where wnioski.id_wn = '$idwnpost'
and uprawnienia.login_mod != ''
and uprawnienia.haslo_mod != '' ");
$ile_login2=mysql_num_rows($loginy2);

// w zmienn± $text_body wpisujemy tre¶æ maila
$text_body = "Dzia³ Informatyki zamkn±³ wniosek o dostêp do danych osobowych<br>";
$text_body .= "dla pracownika $imie $nazwisko <br><br>";

if ($ile_login2 > 0)
	{
	$text_body .= "Dodatkowe informacje:<br>";
	$text_body .= "<table border=1><tr>";	
	$text_body .= "<td><b>Nazwa Systemu</b></td>";
	$text_body .= "<td><b>Nazwa Modu³u</b></td>";
	$text_body .= "<td><b>Login</b></td>";
	$text_body .= "<td><b>Pocz±tkowe has³o</b></td>";
	$text_body .= "</tr>";
	}
for($j = 0; $j < $ile_login2; $j++)
	{
	$loginpass2=mysql_fetch_array($loginy2);
	$text_body .= "<tr>";
	$text_body .= "<td>$loginpass2[nazwa_sys]</td>";
	$text_body .= "<td>$loginpass2[nazwa_mod]</td>";
	$text_body .= "<td>$loginpass2[login_mod]</td>";
	$text_body .= "<td>$loginpass2[haslo_mod]</td>";
	$text_body .= "</tr>";
	}
if ($ile_login2 > 0)
	{
	$text_body .= "</table>";
	}


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
$text_body = "Dzia³ Informatyki zamkn±³ wniosek o dostêp do danych osobowych<br>";
$text_body .= "dla pracownika $imie $nazwisko <br><br>";



$mail->Body = $text_body;
// adresatów dodajemy poprzez metode 'AddAddress'
//$mail->AddAddress("darekm@rpwik.tychy.pl","Dzia³ NI");
$mail->AddAddress("kadry@rpwik.tychy.pl", "Dzia³ Kadr");

if(!$mail->Send())
echo "B³±d podczas wysy³ania powiadomienia <br>";
echo $mail->ErrorInfo."<br>";

// Clear all addresses and attachments
$mail->ClearAddresses();
$mail->ClearAttachments();
//echo "Powiadomienie wys³ano <br>";

?>