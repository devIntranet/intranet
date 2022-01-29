<?
session_start();

$d=$_POST['d'];
$dopoprawy=$_POST['dopoprawy'];
$idwnpost=$_POST['idwnpost'];
$imie=$_POST['imie'];
$nazwisko=$_POST['nazwisko'];

$det=$_GET['det'];
$idwn=$_GET['idwn'];

$status[1] = "Oczekuje na NI";
$status[2] = "Oczekuje na NK";
$status[3] = "Oczekuje na zmianę";
$status[4] = "Gotowy, zamknięty";

echo "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
<title>
Wnioski- test
</title>
<link rel=stylesheet type=text/css href=/Strona/style.css>
<style type='text/css'>
.verticaltext{
font: bold 13px Arial;
position: absolute;
right: 3px;
top: 20px;
width: 15px;
writing-mode: tb-rl;
}
body {background-image: url(/Strona/tlo4.jpg); background-attachment:fixed; background-position: top left}
</style>
</head>
<body>
";

$remote_user = $_SERVER['REMOTE_USER'];
list($domena, $user) = explode("\\", $remote_user);

$ldaprdn  = 'admin';     // ldap rdn or dn
$ldappass = 'c0k0lwiek';  // associated password
// connect to ldap server
$ldapconn = ldap_connect("192.168.1.97")
    or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);
if ($ldapconn) 
	{
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	$base_dn = "dc=rpwik, dc=tychy, dc=pl";
	$filter = "(sAMAccountName=$user)";
	$justthese = array("department", "directreports", "title", "displayname");
	$read = ldap_search($ldapconn, $base_dn, $filter, $justthese);
	$entry = ldap_get_entries($ldapconn, $read);
	#echo var_dump($entry);
	$loginad=$row["loginad_u"];
	$filtr = "(sAMAccountName=$user)";
	$wyjatki = array("department", "title", "sAMAccountName", "displayname");
	$czytaj = ldap_search($ldapconn, $base_dn, $filtr, $wyjatki);
	$wpis = ldap_get_entries($ldapconn, $czytaj);
	echo "Użytkownik: " .$wpis[0]['displayname'][0]. "<BR>";
	echo "Dział: " .$wpis[0]['department'][0]. "<BR>";
	$department = $wpis[0]['department'][0];
	echo "Login: $user<BR>";
	$sprawdz_usera_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$sprawdz_usera=mysql_db_query("ewidencja", "select uzytkownicy.id_u, uzytkownicy.loginad_u, uzytkownicy.id_dz, dzialy.symbol_d 
	from uzytkownicy
	left join dzialy
	on uzytkownicy.id_dz = dzialy.id_dz
	where uzytkownicy.loginad_u = '$user'");
	$ile_sprawdz_usera=mysql_num_rows($sprawdz_usera);
if ($ile_sprawdz_usera != 1)
	{
	echo "<center>Brak twojego użytkownika w bazie danych.<br>
		Skontaktuj się z działem Informatyki.</center>
		";
		}
if  ($ile_sprawdz_usera == 1)
	{
	$user_dzial=mysql_fetch_array($sprawdz_usera);
	$dzial_ad=$wpis[0][department][0];		
	if (($entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NK))
		{
		$wniosek_user='knk';
		}
	if (($entry[0]['directreports'][0]) && ($wpis[0]['department'][0] != NK) && ($wpis[0]['department'][0] != NI))
		{
		$wniosek_user='kxx';
		}
	if ((!$entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NK))
		{
		$wniosek_user='pnk';
		}
	if ((!$entry[0]['directreports'][0]) && ($wpis[0]['department'][0] != NK) && ($wpis[0]['department'][0] != NI))
		{
		$wniosek_user='pxx';
		}
	if (($wpis[0]['department'][0] == NI))
		{
		$wniosek_user='ni';
		}
	echo "Profil: $wniosek_user";
	
		if ($wniosek_user == ni)
			{
			$menu = "
			<table>
			<tr>
			<td>
			<form method=post action=wniosek.php>
			<input type=hidden name=d value=1>
			<input type=submit name=go value='złóź wniosek'>
			</form>
			</td>
			<td>
			<form method=post action=wniosek.php>
			<input type=hidden name=d value=2>
			<input type=submit name=wroc value='wszystkie wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=wniosek.php method=post>
			<input type=hidden name=d value=3>
			<input type=submit name=wybierz value='zamknięte wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=wniosek.php method=post>
			<input type=hidden name=d value=4>
			<input type=submit name=wybierz value='otwarte wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=wniosek.php method=post>
			<input type=hidden name=d value=5>
			<input type=submit name=wybierz value='zasoby papierowe'>
			</form>
			</td>
			</tr>
			</table>
			";
			}
		if ($wniosek_user == kxx)
			{
			#require('wniosek_kxx.inc.php');
			$menu = "
			<table>
			<tr>
			<td>
			<form method=post action=wniosek.php>
			<input type=hidden name=d value=1>
			<input type=submit name=go value='złóź wniosek'>
			</form>
			</td>
			<td>
			<form method=post action=wniosek.php>
			<input type=hidden name=d value=2>
			<input type=submit name=wroc value='moje wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=wniosek.php method=post>
			<input type=hidden name=d value=5>
			<input type=submit name=wybierz value='zasoby papierowe'>
			</form>
			</td>
			</tr>
			</table>
			";
			}
		if ($wniosek_user == pnk)
			{
			require('wniosek_pnk.inc.php');
			}
		if ($wniosek_user == pxx)
			{
			require('wniosek_pxx.inc.php');
			}
		if ($wniosek_user == ni)
			{
			#require('wniosek_ni.inc.php');
			}
	}

echo "
	$menu	
	";
if (($det == 'zmwn') && ($wniosek_user == 'kxx'))
	{
	$d = 2;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '1' where id_wn = '$idwnpost'");
	}
if (($det == 'zatwn') && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '2' where id_wn = '$idwn'");
	}
if (($dopoprawy) && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$dopoprawy_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$dopoprawy=mysql_db_query("ewidencja", "update wnioski set status_wn = '3' where id_wn = '$idwnpost'");
	}
if ($d == 1)
	{
	
	echo "
	<br>
	<br>
	<br>
	<table>
	<tr>
	<form action=wniosek.php?det=dw method=post>
	<td>Imię</td>
	<td><input type=text name=imie></td>
	</tr>
	<tr>
	<td>Nazwisko</td>
	<td><input type=text name=nazwisko></td>
	</tr>
	<tr>
	<td>Dział</td>
	<td>
	
			";
			$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz from dzialy where symbol_d = '$department'");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			for($i = 0; $i < $ile_dzialow; $i++)
				{
				$dzialy=mysql_fetch_array($jakie_dzialy);
				echo "
				$dzialy[nazwa_d]
				";
				}
	echo "
	</td>
	</tr>
	</table>
	<hr>
	<br>
	";
	$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe where id_dz = '$dzialy[id_dz]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	echo "
	<h4>Zakres Uprawnień (przetwarzania danych osobowych):</h4>
	<h5>1. Tradycyjna Ewidencja Zasobów Papierowych</h5>
	<table>
	<tr>
	<td><div style=' font-weight: bold;'>Nazwa zbioru</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold;text-align: left'>Bez ograniczeń</div></td>
	</tr>
	";
	for($i = 0; $i < $ile_zaspap; $i++)
				{
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$idzaspap = $zaspap[id_zaspap];
				echo "
				<tr>
				<td>$zaspap[nazwa_zaspap]</td>
				<td><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1'/></td>
				<td><input type=checkbox name='wprowadznie_zaspap[$idzaspap]' value='1'/></td>
				<td><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1'/></td>
				<td><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1'/></td>
				<td><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1'/></td>
				</tr>
				";
				}
	echo "
	</table>
	<hr>
	<br>
	";
	
	$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.id_sys, systemy.nazwa_sys, moduly.id_mod, moduly.nazwa_mod 
	from systemy
	join moduly
	on systemy.id_sys = moduly.id_sys
	order by id_sys, id_mod");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	echo "
	<h5>2. Aplikacje, programy, systemy umieszczone na serwerach/komputerze</h5>
	<table>
	<tr>
	<td><div style=' font-weight: bold;'>Nazwa Systemu /<br> Programu / Aplikacji</div></td>
	<td><div style=' font-weight: bold;'>Nazwa Modułu</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
	</tr>
	";
	for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				echo "
				<tr>
				<td>$sysmod[nazwa_sys]</td>
				<td>$sysmod[nazwa_mod]</td>
				<td><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1'/></td>
				<td><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1'/></td>
				<td><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1'/></td>
				<td><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1'/></td>
				<td><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1'/></td>
				</tr>
				";
				}
	echo "
	</table>
	<hr>
	<br>
	<h5>3. Pełne uprawnienie do tradycyjnej Ewidencji Zasobów Papierowych<br>
	oraz wszystkich systemów informatycznych, aplikacji i programów
	<input type=checkbox name='$allsys'/></h5>
	<input type=submit name=wyslijwniosek value='złóź wniosek'>
	</form>";
	
	}
if ($det == 'dw')
	{
	
	$insert_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl) 
	values ('$nazwisko', '$imie', '$user_dzial[id_dz]', '$user_dzial[id_u]', 1, CURDATE())");
	$auto_inc_id=mysql_insert_id($insert_wniosek_connect);
	mysql_close($insert_wniosek_connect);
	
	echo "
	<h2>Podałeś dane:</h2>
	Imię: $imie<br>
	Nazwisko: $nazwisko
	<hr><br>
	<h2>Zasoby papierowe</h2>
	<table>
	<tr>
	<td>Nazwa zasobu</td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
	</tr>
	
	";
	$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz from dzialy where symbol_d = '$department'");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			for($i = 0; $i < $ile_dzialow; $i++)
				{
				$dzialy=mysql_fetch_array($jakie_dzialy);
				}
	$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe where id_dz = '$dzialy[id_dz]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	for($i = 0; $i < $ile_zaspap; $i++)
				{
				#echo " TYLE: $ile_zaspap";
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$j = $i+1;
				$idzaspap2 = $zaspap[id_zaspap];
				$odczyt_arr = $_POST[odczyt_zaspap];
				$wprowadznie_arr = $_POST[wprowadznie_zaspap];
				$modyfikacja_arr = $_POST[modyfikacja_zaspap];
				$usuwanie_arr = $_POST[usuwanie_zaspap];
				$bezograniczen_arr = $_POST[bezograniczen_zaspap];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadznie_arr). "<br>";
				$insert_uprawnienia_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				$insert_uprawnienia_zaspap=mysql_db_query("ewidencja", "insert into uprawnienia 
				(id_zaspap, odczyt, wprowadzanie, modyfikacja, usuwanie, bezograniczen, id_wn) 
				values ('$idzaspap2', '$odczyt_arr[$idzaspap2]', '$wprowadznie_arr[$idzaspap2]',
				'$modyfikacja_arr[$idzaspap2]', '$usuwanie_arr[$idzaspap2]',
				'$bezograniczen_arr[$idzaspap2]', '$auto_inc_id')");
				echo "
				<tr>
				<td>$zaspap[nazwa_zaspap]</td>
				<td>$odczyt_arr[$idzaspap2]</td>
				<td>$wprowadznie_arr[$idzaspap2]</td>
				<td>$modyfikacja_arr[$idzaspap2]</td>
				<td>$usuwanie_arr[$idzaspap2]</td>
				<td>$bezograniczen_arr[$idzaspap2]</td>
				</tr>
				";
				}
			echo "
			</table>
			<hr>
			<br>
			<h2>Systemy, programy, aplikacje</h2>
			<table>
			<tr>
			<td>Nazwa systemu</td>
			<td>Nazwa modułu</td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
			</tr>
			";
			
	
	$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.id_sys, systemy.nazwa_sys, moduly.id_mod, moduly.nazwa_mod 
	from systemy
	join moduly
	on systemy.id_sys = moduly.id_sys
	order by id_sys, id_mod");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	for($i = 0; $i < $ile_sysmod; $i++)
				{
				#echo " TYLE: $ile_sysmod $_POST[wprowadznie_sysmod]";
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod2 = $sysmod[id_mod];
				$odczyt_sysmod_arr = $_POST[odczyt_sysmod];
				$wprowadznie_sysmod_arr = $_POST[wprowadzanie_sysmod];
				$modyfikacja_sysmod_arr = $_POST[modyfikacja_sysmod];
				$usuwanie_sysmod_arr = $_POST[usuwanie_sysmod];
				$bezograniczen_sysmod_arr = $_POST[bezograniczen_sysmod];
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadznie_sysmod_arr). "<br>";
				$insert_uprawnienia_sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				$insert_uprawnienia_sysmod=mysql_db_query("ewidencja", "insert into uprawnienia 
				(id_mod, odczyt, wprowadzanie, modyfikacja, usuwanie, bezograniczen, id_wn) 
				values ('$idsysmod2', '$odczyt_sysmod_arr[$idsysmod2]', '$wprowadznie_sysmod_arr[$idsysmod2]',
				'$modyfikacja_sysmod_arr[$idsysmod2]', '$usuwanie_sysmod_arr[$idsysmod2]',
				'$bezograniczen_sysmod_arr[$idsysmod2]', '$auto_inc_id')");
				echo "
				<tr>
				<td>$sysmod[nazwa_sys]</td>
				<td>$sysmod[nazwa_mod]</td>
				<td>$odczyt_sysmod_arr[$idsysmod2]</td>
				<td>$wprowadznie_sysmod_arr[$idsysmod2]</td>
				<td>$modyfikacja_sysmod_arr[$idsysmod2]</td>
				<td>$usuwanie_sysmod_arr[$idsysmod2]</td>
				<td>$bezograniczen_sysmod_arr[$idsysmod2]</td>
				</tr>
				";
				}
	
#	echo "
#	Papier 1:<br> O:$_POST[zaspap1odczyt] W- $_POST[zaspap1wprowadznie] M- $_POST[zaspap1modyfikacja] U- $_POST[zaspap1usuwanie] B- $_POST[zaspap1bezograniczen] <br>
#	Papier 2:<br> O:$_POST[zaspap2odczyt] W- $_POST[zaspap2wprowadznie] M- $_POST[zaspap2modyfikacja] U- $_POST[zaspap2usuwanie] B- $_POST[zaspap2bezograniczen] <br> 
#	";
	}
if ($d == 2)
	{
	echo "
	<br>
	<br>
	<br>
	<h4>Wszystkie wnioski</h4>
	<table>
	<tr>
	<td>Nazwisko</td>
	<td>Imie</td>
	<td>Dzial</td>
	<td>Wniosek złożył</td>
	<td>Status</td>
	<td>Data złożenia</td>
	<td>Data zatwierdzenia</td>
	<td>Data ostatniej modyfikacji</td>
	</tr>
	";
	$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	if ($wniosek_user == 'knk')
		{
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz");
		}
	if ($wniosek_user == 'kxx')
		{
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz
		where dzialy.symbol_d = '$dzial_ad'");
		}
	if ($wniosek_user == 'ni')
		{
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz");
		}
	if ($wniosek_user == 'pnk')
		{
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz");
		}
	$ile_wnioskow=mysql_num_rows($pokaz_wnioski);
		if ($ile_wnioskow != 0)
			{
			for($i = 0; $i < $ile_wnioskow; $i++)
				{
				$wnioski=mysql_fetch_array($pokaz_wnioski);
				$status_fetch=$wnioski['status_wn'];
				echo "
				<tr>
				<td><a href=wniosek.php?det=pw&idwn=$wnioski[id_wn]>$wnioski[nazwisko]</a></td>
				<td><a href=wniosek.php?det=pw&idwn=$wnioski[id_wn]>$wnioski[imie]</a></td>
				<td>$wnioski[symbol_d]</td>
				<td>$wnioski[nazwa_u] $wnioski[imie_u]</td>
				<td>$status[$status_fetch]</td>
				<td>$wnioski[data_zl]</td>
				<td>$wnioski[data_zat]</td>
				<td>$wnioski[data_mod]</td>
				</tr>
				";
				}
			}
	
	}

if (($det == 'pw') || ($det == 'dozmwn'))
	{
	$det_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$det_wniosek=mysql_db_query("ewidencja", "select nazwisko, imie, status_wn from wnioski where id_wn = '$idwn'");
	$wniosek=mysql_fetch_array($det_wniosek);
	if ($wniosek[status_wn] != 3)
		{
		echo "
		<h2>Szczegóły wniosku:</h2>
		Imię: $wniosek[imie]<br>
		Nazwisko: $wniosek[nazwisko]
		<hr><br>
		<h2>Zasoby papierowe</h2>
		<table>
		<tr>
		<td>Nazwa zasobu</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
		</tr>
		";
		$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz from dzialy where symbol_d = '$department'");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			for($i = 0; $i < $ile_dzialow; $i++)
				{
				$dzialy=mysql_fetch_array($jakie_dzialy);
				}
		$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.id_zaspap, zasoby_papierowe.nazwa_zaspap, uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen
		from uprawnienia 
		left join zasoby_papierowe
		on uprawnienia.id_zaspap = zasoby_papierowe.id_zaspap
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_zaspap > 0");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$j = $i+1;
				$idzaspap2 = $zaspap[id_zaspap];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadznie_arr). "<br>";
				if ($zaspap[odczyt] == 1) {$checked_odczyt = 'checked=checked';}
				if ($zaspap[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked';}
				if ($zaspap[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked';}
				if ($zaspap[usuwanie] == 1) {$checked_usuwanie = 'checked=checked';}
				if ($zaspap[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked';}
				echo "
				<tr>
				<td>$zaspap[nazwa_zaspap]</td>
				<td><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1' $checked_odczyt/></td>
				<td><input type=checkbox name='wprowadznie_zaspap[$idzaspap]' value='1' $checked_wprowadzanie/></td>
				<td><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1' $checked_modyfikacja/></td>
				<td><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1' $checked_usuwanie/></td>
				<td><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1' $checked_bezograniczen/></td>
				</tr>
				";
				$checked_odczyt = '';
				$checked_wprowadzanie = '';
				$checked_modyfikacja = '';
				$checked_usuwanie = '';
				$checked_bezograniczen = '';
				}
			echo "
			</table>
			<hr>
			<br>
			<h2>Systemy, programy, aplikacje</h2>
			<table>
			<tr>
			<td>Nazwa systemu</td>
			<td>Nazwa modułu</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
			</tr>
			";
			
	
		$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.nazwa_sys, systemy.id_sys, moduly.id_mod, moduly.nazwa_mod, 
		uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen
		from uprawnienia 
		left join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on systemy.id_sys = moduly.id_sys
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_mod > 0");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				if ($sysmod[odczyt] == 1) {$checked_odczyt = 'checked=checked';}
				if ($sysmod[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked';}
				if ($sysmod[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked';}
				if ($sysmod[usuwanie] == 1) {$checked_usuwanie = 'checked=checked';}
				if ($sysmod[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked';}
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadznie_sysmod_arr). "<br>";
				echo "
				<tr>
				<td>$sysmod[nazwa_sys]</td>
				<td>$sysmod[nazwa_mod]</td>
				<td><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' $checked_odczyt/></td>
				<td><input type=checkbox name='wprowadznie_sysmod[$idsysmod]' value='1' $checked_wprowadzanie/></td>
				<td><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' $checked_modyfikacja/></td>
				<td><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' $checked_usuwanie/></td>
				<td><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' $checked_bezograniczen/></td>
				</tr>
				";
				$checked_odczyt = '';
				$checked_wprowadzanie = '';
				$checked_modyfikacja = '';
				$checked_usuwanie = '';
				$checked_bezograniczen = '';
				}
	
		echo "
		</table>
		<hr>
		<br><br>
		";
		
		if (($wniosek_user == 'ni') && ($wniosek[status_wn] == '1') && ($det != 'dozmwn'))
			{
			echo "
			<table>
			<tr>
			<td>
			<a href=wniosek.php?det=zatwn&idwn=$idwn>Wniosek poprawny</a>	
			</td>
			<td>
			<a href=wniosek.php?det=dozmwn&idwn=$idwn>Wniosek wymaga zmian</a>	
			</td>
			</tr>
			</table>
			";
			}
		if (($det == 'dozmwn') && ($wniosek_user == 'ni'))
			{
			echo "
			<form action=wniosek.php method=post>
			<textarea name=uwagi_wn cols=50 rows=10>Uwagi:
			</textarea>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=dopoprawy value='zgłoś do poprawy'>
			</form>
			";
			}
		}
		if ($wniosek[status_wn] == 3)
		{
		echo "
		<h2>Popraw wniosek:</h2>
		<table>
		<tr>
		<form action=wniosek.php?det=zmwn method=post>
		<td>Imię</td>
		<td><input type=text name=imie value='$wniosek[imie]'></td>
		</tr>
		<tr>
		<td>Nazwisko</td>
		<td><input type=text name=nazwisko value='$wniosek[nazwisko]'></td>
		</tr>
		</table>
		<hr><br>
		<h2>Zasoby papierowe</h2>
		<table>
		<tr>
		<td>Nazwa zasobu</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
		</tr>
		";
		$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz from dzialy where symbol_d = '$department'");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			for($i = 0; $i < $ile_dzialow; $i++)
				{
				$dzialy=mysql_fetch_array($jakie_dzialy);
				}
		$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.id_zaspap, zasoby_papierowe.nazwa_zaspap, uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen
		from uprawnienia 
		left join zasoby_papierowe
		on uprawnienia.id_zaspap = zasoby_papierowe.id_zaspap
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_zaspap > 0");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$j = $i+1;
				$idzaspap = $zaspap[id_zaspap];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadznie_arr). "<br>";
				if ($zaspap[odczyt] == 1) {$checked_odczyt = 'checked=checked';}
				if ($zaspap[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked';}
				if ($zaspap[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked';}
				if ($zaspap[usuwanie] == 1) {$checked_usuwanie = 'checked=checked';}
				if ($zaspap[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked';}
				echo "
				<tr>
				<td>$zaspap[nazwa_zaspap]</td>
				<td><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1' $checked_odczyt/></td>
				<td><input type=checkbox name='wprowadznie_zaspap[$idzaspap]' value='1' $checked_wprowadzanie/></td>
				<td><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1' $checked_modyfikacja/></td>
				<td><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1' $checked_usuwanie/></td>
				<td><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1' $checked_bezograniczen/></td>
				</tr>
				";
				$checked_odczyt = '';
				$checked_wprowadzanie = '';
				$checked_modyfikacja = '';
				$checked_usuwanie = '';
				$checked_bezograniczen = '';
				}
			echo "
			</table>
			<hr>
			<br>
			<h2>Systemy, programy, aplikacje</h2>
			<table>
			<tr>
			<td>Nazwa systemu</td>
			<td>Nazwa modułu</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeń</div></td>
			</tr>
			";
			
	
		$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.nazwa_sys, systemy.id_sys, moduly.id_mod, moduly.nazwa_mod, 
		uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen
		from uprawnienia 
		left join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on systemy.id_sys = moduly.id_sys
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_mod > 0");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				if ($sysmod[odczyt] == 1) {$checked_odczyt = 'checked=checked';}
				if ($sysmod[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked';}
				if ($sysmod[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked';}
				if ($sysmod[usuwanie] == 1) {$checked_usuwanie = 'checked=checked';}
				if ($sysmod[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked';}
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadznie_sysmod_arr). "<br>";
				echo "
				<tr>
				<td>$sysmod[nazwa_sys]</td>
				<td>$sysmod[nazwa_mod]</td>
				<td><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' $checked_odczyt/></td>
				<td><input type=checkbox name='wprowadznie_sysmod[$idsysmod]' value='1' $checked_wprowadzanie/></td>
				<td><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' $checked_modyfikacja/></td>
				<td><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' $checked_usuwanie/></td>
				<td><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' $checked_bezograniczen/></td>
				</tr>
				";
				$checked_odczyt = '';
				$checked_wprowadzanie = '';
				$checked_modyfikacja = '';
				$checked_usuwanie = '';
				$checked_bezograniczen = '';
				}
	
		echo "
		</table>
		<hr>
		";
		if ($wniosek_user == 'kxx')
			{
			echo "
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=poprawionywniosek value='Popraw wniosek'>
			</form>
			";
			}
	
		
		if (($wniosek_user == 'ni') && ($wniosek[status_wn] == '1') && ($det != 'dozmwn'))
			{
			echo "
			<table>
			<tr>
			<td>
			<a href=wniosek.php?det=zatwn&idwn=$idwn>Wniosek poprawny</a>	
			</td>
			<td>
			<a href=wniosek.php?det=dozmwn&idwn=$idwn>Wniosek wymaga zmian</a>	
			</td>
			</tr>
			</table>
			";
			}
		if (($det == 'dozmwn') && ($wniosek_user == 'ni'))
			{
			echo "
			<form action=wniosek.php method=post>
			<textarea name=uwagi_wn cols=50 rows=10>Uwagi:
			</textarea>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=dopoprawy value='zgłoś do poprawy'>
			</form>
			";
			}
		}
		
	}
	

}
?>