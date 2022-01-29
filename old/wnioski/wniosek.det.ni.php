<?
//echo "
//	$menu	
//	";
$hover="onMouseOver=\"this.style.backgroundColor='#E1EAFE'\"; onMouseOut=\"this.style.backgroundColor='transparent'\"";

if ($det ==  2) $d=$ddet;
if ($wniosekstget !=  "") $d=9;
if ($odwwn) 
	{
	$odw_up_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$odw_up_qry=mysql_db_query("ewidencja", "update wnioski set status_wn = '11', data_mod = CURDATE() where id_wn = '$idwnpost'");
	require("mailtoni4.php");
	mysql_close($odw_up_connect); 
	}
if (($det == 'zatwn') && ($wniosek_user == 'ni'))
	{
	$d = 7;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '5' where id_wn = '$idwn'");
	$jakie_sysmod=mysql_db_query("ewidencja", "select * from uprawnienia where id_wn = '$idwn' and id_mod > 0");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	for($i = 0; $i < $ile_sysmod; $i++)
		{
		$pobierz_dane=mysql_db_query("ewidencja", "select * from wnioski 
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		where wnioski.id_wn = '$idwn' ");
		$dane = mysql_fetch_array($pobierz_dane);
		$imie = $dane[imie];
		$nazwisko = $dane[nazwisko];
		$user2 = $dane[loginad_u];
		$filtr2 = "(sAMAccountName=$user2)";
		$wyjatki2 = array("department", "title", "sAMAccountName", "displayname", "mail");
		$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
		$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
		$aduzytkownik2 = $wpis2[0]['displayname'][0];
		$aduzytkownikmail2 = $wpis2[0]['mail'][0];
		$isologin = $wpis2[0]['displayname'][0];
		$aduzytkownik2 = iconv('UTF-8', 'ISO-8859-2', $isologin);		

		$sysmod=mysql_fetch_array($jakie_sysmod);
		$idmod=$sysmod[id_mod];
		$idwn=$sysmod[id_wn];
		$dodaj_login=mysql_db_query("ewidencja", "update uprawnienia set login_mod = '$loginmod[$idmod]', haslo_mod= '$haslomod[$idmod]'
		where id_mod = $idmod and id_wn = '$idwn'");
		}
	require("mailtoni1.php");
	}
if ($zakonczwniosek)
	{
	$d=7;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '9', data_zat = CURDATE() where id_wn = '$idwnpost'");
	$pobierz_dane=mysql_db_query("ewidencja", "select * from wnioski 
	left join uzytkownicy
	on wnioski.id_u = uzytkownicy.id_u
	left join uprawnienia
	on uprawnienia.id_wn = wnioski.id_wn
	where wnioski.id_wn = '$idwnpost' 
	and uprawnienia.id_mod = 50
	");
	$dane = mysql_fetch_array($pobierz_dane);
	$imie = $dane[imie];
	$nazwisko = $dane[nazwisko];
	$user2 = $dane[loginad_u];
	$filtr2 = "(sAMAccountName=$user2)";
	$wyjatki2 = array("department", "title", "sAMAccountName", "displayname", "mail");
	$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
	$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
	$aduzytkownik2 = $wpis2[0]['displayname'][0];
	$aduzytkownikmail2 = $wpis2[0]['mail'][0];
	$isologin = $wpis2[0]['displayname'][0];
	$aduzytkownik2 = iconv('UTF-8', 'ISO-8859-2', $isologin);
	if ($insertnewuser == 1)
		{
		$create_user=mysql_db_query("ewidencja", "insert into uzytkownicy (nazwa_u, imie_u, id_dz, int_u, loginad_u, id_wn) 
		values ('$dane[nazwisko]', '$dane[imie]', '$dane[id_dz]', 0, '$dane[login_mod]', '$idwnpost')");
		}	
	if ($insertnewuser != 1)
		{
		echo "uzytkownik: $uzytkownik";
		$link_user=mysql_db_query("ewidencja", "update uzytkownicy set id_wn = '$idwnpost' where id_u = '$uzytkownik'");
		}
	if ($sendmailcheckbox != 1)
		{
		require("mailtoni3.php");
		}	
	mysql_close($zatwn_connect);
	}
if (($det == 'uw') && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$uw_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$pokaz_dok=mysql_db_query("ewidencja", "select  *  from dokumenty_wnioski where id_wn = '$idwn' and typ_dok = '0'");
	$pokaz_dok2=mysql_db_query("ewidencja", "select  *  from dokumenty_wnioski where id_wn = '$idwn' and typ_dok = '2'");
	$pokaz_status=mysql_db_query("ewidencja", "select  status_wn from wnioski where id_wn = '$idwn'");
	$wniosek_status=mysql_fetch_array($pokaz_status);
	$wniosek_dok=mysql_fetch_array($pokaz_dok);
	$wniosek_dok2=mysql_fetch_array($pokaz_dok2);
	$wniosek_dok_link=$wniosek_dok[link_dok]; 
	$wniosek_dok2_link=$wniosek_dok2[link_dok];
	$glowna = getcwd(); 
	$wniosek_status=$wniosek_status[status_wn];	
	chdir(dokumenty);
	if ($wniosek_status < 10)	
		{
		//rename($wniosek_dok_link, "usuniete\\$wniosek_dok_link"); 
		}
	if (($wniosek_status >= 10) && ($wniosek_status < 12))
		{
		rename($wniosek_dok_link, "usuniete\\$wniosek_dok_link");
		chdir("odwolania");
		rename($wniosek_dok2_link, "usuniete\\$wniosek_dok2_link");
		}
	chdir($glowna); // Restore the old working directory
	$usun_dok_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$pobierz_dane=mysql_db_query("ewidencja", "select * from wnioski 
	left join uzytkownicy
	on wnioski.id_u = uzytkownicy.id_u
	where wnioski.id_wn = '$idwn' ");
	$usun_dok=mysql_db_query("ewidencja", "delete from dokumenty_wnioski where link_dok = '$wniosek_dok'");
	$uw=mysql_db_query("ewidencja", "delete from wnioski where id_wn = '$idwn'");
	$dane = mysql_fetch_array($pobierz_dane);
	$imie = $dane[imie];
	$nazwisko = $dane[nazwisko];
	$user2 = $dane[loginad_u];
	$filtr2 = "(sAMAccountName=$user2)";
	$wyjatki2 = array("department", "title", "sAMAccountName", "displayname", "mail");
	$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
	$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
	$aduzytkownik2 = $wpis2[0]['displayname'][0];
	$aduzytkownikmail2 = $wpis2[0]['mail'][0];
	$isologin = $wpis2[0]['displayname'][0];
	$aduzytkownik2 = iconv('UTF-8', 'ISO-8859-2', $isologin);
	require("mailtoni5.php");
	}
		
if (($dopoprawy) && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$dopoprawy_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$dopoprawy=mysql_db_query("ewidencja", "insert into uwagi_wn (id_wn, data_uw, uwaga) values ('$idwnpost', CURDATE(), '$uwagawn')");
	$dopoprawy=mysql_db_query("ewidencja", "update wnioski set status_wn = '3' where id_wn = '$idwnpost'");
	
	$pobierz_dane=mysql_db_query("ewidencja", "select * from wnioski 
	left join uzytkownicy
	on wnioski.id_u = uzytkownicy.id_u
	where wnioski.id_wn = '$idwnpost' ");
	$dane = mysql_fetch_array($pobierz_dane);
	$imie = $dane[imie];
	$nazwisko = $dane[nazwisko];
	$user2 = $dane[loginad_u];
	$filtr2 = "(sAMAccountName=$user2)";
	$wyjatki2 = array("department", "title", "sAMAccountName", "displayname", "mail");
	$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
	$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
	$aduzytkownik2 = $wpis2[0]['displayname'][0];
	$aduzytkownikmail2 = $wpis2[0]['mail'][0];
	$isologin = $wpis2[0]['displayname'][0];
	$aduzytkownik2 = iconv('UTF-8', 'ISO-8859-2', $isologin);
	require("mailtoni2.php");
	}
if ($d == 1)
	{
	
	echo "
	<br>
	<br>
	<br>
	<table class=imienazw>
	<tr>
	<form action=index.php?m=up&m=up&det=dw method=post>
	<td>Imiê</td>
	<td><input type=text name=imie></td>
	</tr>
	<tr>
	<td>Nazwisko</td>
	<td><input type=text name=nazwisko></td>
	</tr>
	<tr>
	<td>Dzia³</td>
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
	<tr>
	<td>Obowi±zuje do</td>
	<td>
	<script>DateInput('datado', false, 'YYYY-MM-DD')</script>
	</td>
	<td>
	</tr>
	</table>
	<hr>
	<br>
	";
	$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_dzialy=mysql_db_query("ewidencja", "select dzialy.id_dz, dzialy.nazwa_d, dzialy.symbol_d from dzialy");
	$ile_dzialow=mysql_num_rows($jakie_dzialy);
	echo "
		<h4>Zakres Uprawnieñ (przetwarzania danych osobowych):</h4>
		<h5>1. Tradycyjna Ewidencja Zasobów Papierowych</h5>
		<div class=zaspapgr>		
		";
	for($j = 0; $j < $ile_dzialow; $j++)
		{
		$dzialy2=mysql_fetch_array($jakie_dzialy);
		$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe where id_dz = '$dzialy2[id_dz]'");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		echo "
		<input type='checkbox' name='$dzialy2[symbol_d]' value='warto¶æ'
		onclick=\"document.getElementById('$dzialy2[id_dz]').style.display = this.checked ? 'block' : 'none'; \" />
		
		$dzialy2[nazwa_d]
		
		<br>
		<table class=dot id='$dzialy2[id_dz]' style='display: none'>
		<tr>
		<td class=dot><div style=' font-weight: bold;'>Nazwa zbioru</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Odczyt</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Wprowadzanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Modyfikacja danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Usuwanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Bez ograniczeñ</div></td>
		</tr>
		";
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$idzaspap = $zaspap[id_zaspap];
				echo "
				<tr $hover>
				<td class=dot>$zaspap[nazwa_zaspap]</td>
				<td class=dot><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='wprowadzanie_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1'/></td>
				</tr>
				
				";
				}
		echo "</table>";
		}
		
	echo "
	</div>
	<hr>
	<br>
	";
	
	$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	### Dodane sprawdzanie uprawnien defaultowych ###
	$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.id_sys, systemy.nazwa_sys, moduly.id_mod, moduly.nazwa_mod, moduly.opis_mod,
	uprawnienia_default.id_ud, uprawnienia_default.odczyt, uprawnienia_default.wprowadzanie, 
	uprawnienia_default.modyfikacja, uprawnienia_default.usuwanie, uprawnienia_default.bez_ograniczen 
	from systemy
	join moduly
	on systemy.id_sys = moduly.id_sys
	left join uprawnienia_default
	on moduly.id_mod = uprawnienia_default.id_mod
	order by id_sys, moduly.id_mod");
	### Dodane sprawdzanie uprawnien defaultowych ###

	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	### Dodane sprawdzanie uprawnien defaultowych ###
	echo "
	<h5>2. Aplikacje, programy, systemy umieszczone na serwerach/komputerze</h5>
	<table class=dot>
	<tr>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Systemu /<br> Programu / Aplikacji</div></td>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Modu³u</div></td>
	<td class=dot><div style=' font-weight: bold;'>Zakres stanowiskowy</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Dostêp</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: center'>Bez ograniczeñ</div></td>
	</tr>
	";
	### Dodane sprawdzanie uprawnien defaultowych ###
	for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				$def_box_start = "onclick=\" this.form.elements['odczyt_sysmod[$idsysmod]'].disabled = this.form.elements['wprowadzanie_sysmod[$idsysmod]'].disabled = 
				this.form.elements['modyfikacja_sysmod[$idsysmod]'].disabled = this.form.elements['usuwanie_sysmod[$idsysmod]'].disabled = 
				this.form.elements['bezograniczen_sysmod[$idsysmod]'].disabled =!this.checked; ";
				if ($sysmod[odczyt] == 1) 
					{ 
					$odczyt_def_box = "this.form.elements['odczyt_sysmod[$idsysmod]'].checked=checked; ";
					}
					if ($sysmod[odczyt] != 1)
						{
						$odczyt_def_box = "this.form.elements['odczyt_sysmod[$idsysmod]'].checked=false; ";
						}
				if ($sysmod[wprowadzanie] == 1) 
					{ 
					$wprowadzanie_def_box = "this.form.elements['wprowadzanie_sysmod[$idsysmod]'].checked=checked; ";
					}
					if ($sysmod[wprowadzanie] != 1)
						{
						$wprowadzanie_def_box = "this.form.elements['wprowadzanie_sysmod[$idsysmod]'].checked=false; ";
						}
				if ($sysmod[modyfikacja] == 1) 
					{ 
					$modyfikacja_def_box = "this.form.elements['modyfikacja_sysmod[$idsysmod]'].checked=checked; ";
					}
					if ($sysmod[modyfikacja] != 1)
						{
						$modyfikacja_def_box = "this.form.elements['modyfikacja_sysmod[$idsysmod]'].checked=false; ";
						}
				if ($sysmod[usuwanie] == 1) 
					{ 
					$usuwanie_def_box = "this.form.elements['usuwanie_sysmod[$idsysmod]'].checked=checked; ";
					}
					if ($sysmod[usuwanie] != 1)
						{
						$usuwanie_def_box = "this.form.elements['usuwanie_sysmod[$idsysmod]'].checked=false; ";
						;
						}
				if ($sysmod[bez_ograniczen] == 1) 
					{ 
					$bezograniczen_def_box = "this.form.elements['bezograniczen_sysmod[$idsysmod]'].checked=checked; ";
					}
					if ($sysmod[bez_ograniczen] != 1)
						{
						$bezograniczen_def_box = "this.form.elements['bezograniczen_sysmod[$idsysmod]'].checked=false; ";
						;
						}
				$def_box_end = "\"";
				$def_box= $def_box_start . $odczyt_def_box . $wprowadzanie_def_box . $modyfikacja_def_box . $usuwanie_def_box . $bezograniczen_def_box . $def_box_end;
				#echo $def_box;
				
				### Dodane sprawdzanie uprawnien defaultowych ###
				echo "
				<tr $hover>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>
				<div style=\"margin:10 10\">
				
				<span style=\"position:relative\">
				<a  
				onmouseover=\"chmurka(this,1)\" 
				onmouseout=\"chmurka(this,0)\"> 
				$sysmod[nazwa_mod]</a>
				<div class=\"dymek\"> $sysmod[opis_mod]
				</div></span>
				</div>
				</td>
				<td class=dot>
				";
				#$stanowisko_connect=mysql_connect("localhost", "root", "pwtychy");
				#mysql_query("SET NAMES latin2");
				$jakie_stanowiska=mysql_db_query("ewidencja", "select * from stanowiska_moduly
				left join stanowiska_lista
				on stanowiska_moduly.id_st = stanowiska_lista.id_st
				where
				stanowiska_moduly.id_mod = $idsysmod
				");
				$ile_stanowisk=mysql_num_rows($jakie_stanowiska);
				if ($ile_stanowisk > 0)
					{
					echo ":
					<select name=stanowisko_select[$idsysmod]>
					";
					for($j = 0; $j < $ile_stanowisk; $j++)
						{
						$stanowiska=mysql_fetch_array($jakie_stanowiska);
						echo ":
						<option value='$stanowiska[id_st]'>$stanowiska[stanowisko]</option>
						";
						}
					echo "</select>";
					}
				echo "
				</td>
				<td class=dot><div name=raz><input type=checkbox name='dostep_sysmod[$idsysmod]' value='1' $def_box/></td>
				<td class=dot><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
				<td class=dot><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
				<td class=dot><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' disabled='disabled'/></div></td>
				<td class=dot><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
				<td class=dot><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
				</tr>
				";
				$odczyt_def_box = "";
				$wprowadzanie_def_box = "";
				$modyfikacja_def_box = "";
				$usuwanie_def_box = "";
				$bezograniczen_def_box = "";
				### Dodane sprawdzanie uprawnien defaultowych ###
				}
	echo "
	</table>
	<hr>
	<br>
	<input class=s_zlozwn type=submit name=wyslijwniosek value=''>
	</form>
	<br><br><br><br>

	";
	
	}
if (($det == 'dw') || ($det == 'popw'))
	{
	$insert_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");

	if ($det == 'dw')
		{
		if ($datado)
			{
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od, data_do) 
			values ('$nazwisko', '$imie', '$user_dzial[id_dz]', '$user_dzial[id_u]', 5, CURDATE(), CURDATE(), '$datado')");
			}
		if (!$datado)
			{
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od) 
			values ('$nazwisko', '$imie', '$user_dzial[id_dz]', '$user_dzial[id_u]', 5, CURDATE(), CURDATE())");
			}
		$auto_inc_id=mysql_insert_id($insert_wniosek_connect);
		mysql_close($insert_wniosek_connect);
		echo "
		<h2>Poda³e¶ dane:</h2>
		Imiê: $imie<br>
		Nazwisko: $nazwisko
		<hr><br>
		";
		}
	if ($det == 'popw')
		{
		$znajdz_wniosek=mysql_db_query("ewidencja", "select * from wnioski where id_wn = '$idwnpost'");
		$wniosek=mysql_fetch_array($znajdz_wniosek);
		mysql_close($insert_wniosek_connect);
		echo "
		<h2>Poprawiony wniosek:</h2>
		Imiê: $wniosek[imie]<br>
		Nazwisko: $wniosek[nazwisko]
		<hr><br>
		";
		}
	echo "
	<h2>Zasoby papierowe</h2>
	<table class=dot>
	<tr>
	<td class=dot>Nazwa zasobu</td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
	</tr>
	
	";
	if ($det == 'dw')
		{
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
		$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe order by id_dz, id_zaspap");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				#echo " TYLE: $ile_zaspap";
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$j = $i+1;
				$idzaspap2 = $zaspap[id_zaspap];
				$odczyt_arr = $_POST[odczyt_zaspap];
				$wprowadzanie_arr = $_POST[wprowadzanie_zaspap];
				$modyfikacja_arr = $_POST[modyfikacja_zaspap];
				$usuwanie_arr = $_POST[usuwanie_zaspap];
				$bezograniczen_arr = $_POST[bezograniczen_zaspap];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadzanie_arr). "<br>";
				$insert_uprawnienia_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				if (($odczyt_arr[$idzaspap2] == 1) || ($wprowadzanie_arr[$idzaspap2] ==1 ) || ($modyfikacja_arr[$idzaspap2] == 1)
				|| ($usuwanie_arr[$idzaspap2] == 1) || ($bezograniczen_arr[$idzaspap2] == 1))
					{
					$insert_uprawnienia_zaspap=mysql_db_query("ewidencja", "insert into uprawnienia 
					(id_zaspap, odczyt, wprowadzanie, modyfikacja, usuwanie, bezograniczen, id_wn) 
					values ('$idzaspap2', '$odczyt_arr[$idzaspap2]', '$wprowadzanie_arr[$idzaspap2]',
					'$modyfikacja_arr[$idzaspap2]', '$usuwanie_arr[$idzaspap2]',
					'$bezograniczen_arr[$idzaspap2]', '$auto_inc_id')");
					if ($odczyt_arr[$idzaspap2] == 1) $odczytimg = "<img src=img/checked.gif>";
					if ($wprowadzanie_arr[$idzaspap2] == 1) $wprowadzanieimg = "<img src=img/checked.gif>";
					if ($modyfikacja_arr[$idzaspap2] == 1) $modyfikacjaimg = "<img src=img/checked.gif>";
					if ($usuwanie_arr[$idzaspap2] == 1) $usuwanieimg = "<img src=img/checked.gif>";
					if ($bezograniczen_arr[$idzaspap2] == 1) $bezograniczenimg = "<img src=img/checked.gif>";
					
					echo "
					<tr $hover>
					<td class=dot>$zaspap[nazwa_zaspap]</td>
					<td class=dot>$odczytimg</td>
					<td class=dot>$wprowadzanieimg</td>
					<td class=dot>$modyfikacjaimg</td>
					<td class=dot>$usuwanieimg</td>
					<td class=dot>$bezograniczenimg</td>
					</tr>
					";
					$odczytimg= "";
					$wprowadzanieimg= "";
					$modyfikacjaimg= "";
					$usuwanieimg= "";
					$bezograniczenimg= "";
					}
				}
			}
			
			
			
			
	if ($det == 'popw')
		{
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
		$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, uprawnienia.id_zaspap,
        uprawnienia.id_wn		
        from uprawnienia
		inner join zasoby_papierowe 
		on uprawnienia.id_zaspap = zasoby_papierowe.id_zaspap
		where uprawnienia.id_wn = '$idwnpost'
		order by id_zaspap");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				#echo " TYLE: $ile_zaspap";
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$j = $i+1;
				$idzaspap2 = $zaspap[id_zaspap];
				$odczyt_arr = $_POST[odczyt_zaspap];
				$wprowadzanie_arr = $_POST[wprowadzanie_zaspap];
				$modyfikacja_arr = $_POST[modyfikacja_zaspap];
				$usuwanie_arr = $_POST[usuwanie_zaspap];
				$bezograniczen_arr = $_POST[bezograniczen_zaspap];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadzanie_arr). "<br>";
				$insert_uprawnienia_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				if (($odczyt_arr[$idzaspap2] == 1) || ($wprowadzanie_arr[$idzaspap2] ==1 ) || ($modyfikacja_arr[$idzaspap2] == 1)
				|| ($usuwanie_arr[$idzaspap2] == 1) || ($bezograniczen_arr[$idzaspap2] == 1))
					{
					$update_uprawnienia_zaspap=mysql_db_query("ewidencja", "update uprawnienia 
					set odczyt = '$odczyt_arr[$idzaspap2]',
					wprowadzanie = '$wprowadzanie_arr[$idzaspap2]',
					modyfikacja = '$modyfikacja_arr[$idzaspap2]',
					usuwanie = '$usuwanie_arr[$idzaspap2]',
					bezograniczen = '$bezograniczen_arr[$idzaspap2]'
					where id_wn = '$idwnpost' 
					and id_zaspap = '$idzaspap2'");
					if ($odczyt_arr[$idzaspap2] == 1) $odczytimg = "<img src=img/checked.gif>";
					if ($wprowadzanie_arr[$idzaspap2] == 1) $wprowadzanieimg = "<img src=img/checked.gif>";
					if ($modyfikacja_arr[$idzaspap2] == 1) $modyfikacjaimg = "<img src=img/checked.gif>";
					if ($usuwanie_arr[$idzaspap2] == 1) $usuwanieimg = "<img src=img/checked.gif>";
					if ($bezograniczen_arr[$idzaspap2] == 1) $bezograniczenimg = "<img src=img/checked.gif>";
					}
				if (($odczyt_arr[$idzaspap2] == 0) && ($wprowadzanie_arr[$idzaspap2] == 0 ) && ($modyfikacja_arr[$idzaspap2] == 0)
				&& ($usuwanie_arr[$idzaspap2] == 0) && ($bezograniczen_arr[$idzaspap2] == 0))
					{
					$delete_from_uprawnienia_zaspap=mysql_db_query("ewidencja", "delete from uprawnienia 
					where id_wn = '$idwnpost'
					and id_zaspap = '$idzaspap2' ");
					}
				
				echo "
				<tr $hover>
				<td class=dot>$zaspap[nazwa_zaspap]</td>
				<td class=dot>$odczytimg</td>
				<td class=dot>$wprowadzanieimg</td>
				<td class=dot>$modyfikacjaimg</td>
				<td class=dot>$usuwanieimg</td>
				<td class=dot>$bezograniczenimg</td>
				</tr>
				";
				$odczytimg = "";
				$wprowadzanieimg = "";
				$wprowadzanie_arr[$idzaspap2] = "";
				$modyfikacjaimg = "";
				$usuwanieimg = "";
				$bezograniczenimg = "";
					
				}
							
			}

			
			
			
			
			echo "
			</table>
			<hr>
			<br>
			<h2>Systemy, programy, aplikacje</h2>
			<table class=dot>
			<tr>
			<td class=dot>Nazwa systemu</td>
			<td class=dot>Nazwa modu³u</td>
			<td class=dot>Zakres stanowiska</td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
			</tr>
			";
			
	
	if ($det == 'dw')
		{
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
				#echo " TYLE: $ile_sysmod $_POST[wprowadzanie_sysmod]";
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod2 = $sysmod[id_mod];
				$odczyt_sysmod_arr = $_POST[odczyt_sysmod];
				$wprowadzanie_sysmod_arr = $_POST[wprowadzanie_sysmod];
				$modyfikacja_sysmod_arr = $_POST[modyfikacja_sysmod];
				$usuwanie_sysmod_arr = $_POST[usuwanie_sysmod];
				$bezograniczen_sysmod_arr = $_POST[bezograniczen_sysmod];
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadzanie_sysmod_arr). "<br>";
				$insert_uprawnienia_sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				$insert_uprawnienia_sysmod=mysql_db_query("ewidencja", "insert into uprawnienia 
				(id_st, id_mod, odczyt, wprowadzanie, modyfikacja, usuwanie, bezograniczen, id_wn) 
				values ('$stanowisko_select[$idsysmod2]', '$idsysmod2', '$odczyt_sysmod_arr[$idsysmod2]', '$wprowadzanie_sysmod_arr[$idsysmod2]',
				'$modyfikacja_sysmod_arr[$idsysmod2]', '$usuwanie_sysmod_arr[$idsysmod2]',
				'$bezograniczen_sysmod_arr[$idsysmod2]', '$auto_inc_id')");
				if ($odczyt_sysmod_arr[$idsysmod2] == 1) $odczytimg = "<img src=img/checked.gif>";
				if ($wprowadzanie_sysmod_arr[$idsysmod2] == 1) $wprowadzanieimg = "<img src=img/checked.gif>";
				if ($modyfikacja_sysmod_arr[$idsysmod2] == 1) $modyfikacjaimg = "<img src=img/checked.gif>";
				if ($usuwanie_sysmod_arr[$idsysmod2] == 1) $usuwanieimg = "<img src=img/checked.gif>";
				if ($bezograniczen_sysmod_arr[$idsysmod2] == 1) $bezograniczenimg = "<img src=img/checked.gif>";
				$select_stanowiska=mysql_db_query("ewidencja", "select stanowisko from stanowiska_lista where id_st = '$stanowisko_select[$idsysmod2]'
				");
				$stanowisko2=mysql_fetch_array($select_stanowiska);
				echo "
				<tr $hover>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
				<td class=dot>$stanowisko2[stanowisko]</td>
				<td class=dot>$odczytimg</td>
				<td class=dot>$wprowadzanieimg</td>
				<td class=dot>$modyfikacjaimg</td>
				<td class=dot>$usuwanieimg</td>
				<td class=dot>$bezograniczenimg</td>
				</tr>
				";
				$odczytimg = "";
				$wprowadzanieimg = "";
				$modyfikacjaimg = "";
				$usuwanieimg = "";
				$bezograniczenimg = "";
				}
	
	}


		
	if ($det == 'popw')
		{
		$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$update_wniosek=mysql_db_query("ewidencja", "update wnioski set status_wn = '4', data_mod = CURDATE() where id_wn = '$idwnpost'");
		$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.nazwa_sys, moduly.nazwa_mod,
        uprawnienia.id_wn, uprawnienia.id_mod		
        from uprawnienia
		inner join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on moduly.id_sys = systemy.id_sys
		where uprawnienia.id_wn = '$idwnpost'
		");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				#echo " TYLE: $ile_zaspap";
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$j = $i+1;
				$idsysmod2 = $sysmod[id_mod];
				$odczyt_arr = $_POST[odczyt_sysmod];
				$wprowadzanie_arr = $_POST[wprowadzanie_sysmod];
				$modyfikacja_arr = $_POST[modyfikacja_sysmod];
				$usuwanie_arr = $_POST[usuwanie_sysmod];
				$bezograniczen_arr = $_POST[bezograniczen_sysmod];
				#echo var_dump($odczyt_arr). "<br>";
				#echo var_dump($wprowadzanie_arr). "<br>";
				$update_uprawnienia_sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
				mysql_query("SET NAMES latin2");
				if (($odczyt_arr[$idsysmod2] == 1) || ($wprowadzanie_arr[$idsysmod2] ==1 ) || ($modyfikacja_arr[$idsysmod2] == 1)
				|| ($usuwanie_arr[$idsysmod2] == 1) || ($bezograniczen_arr[$idsysmod2] == 1))
					{
					$update_uprawnienia_sysmod=mysql_db_query("ewidencja", "update uprawnienia 
					set id_st = '$stanowisko_select',
					odczyt = '$odczyt_arr[$idsysmod2]',
					wprowadzanie = '$wprowadzanie_arr[$idsysmod2]',
					modyfikacja = '$modyfikacja_arr[$idsysmod2]',
					usuwanie = '$usuwanie_arr[$idsysmod2]',
					bezograniczen = '$bezograniczen_arr[$idsysmod2]'
					where id_wn = '$idwnpost' 
					and id_mod = '$idsysmod2'");
					if ($odczyt_arr[$idsysmod2] == 1) $odczytimg = "<img src=img/checked.gif>";
					if ($wprowadzanie_arr[$idsysmod2] == 1) $wprowadzanieimg = "<img src=img/checked.gif>";
					if ($modyfikacja_arr[$idsysmod2] == 1) $modyfikacjaimg = "<img src=img/checked.gif>";
					if ($usuwanie_arr[$idsysmod2] == 1) $usuwanieimg = "<img src=img/checked.gif>";
					if ($bezograniczen_arr[$idsysmod2] == 1) $bezograniczenimg = "<img src=img/checked.gif>";
					}
				
				echo "
				<tr $hover>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
				<td class=dot>$stanowisko_select</td>
				<td class=dot>$odczytimg</td>
				<td class=dot>$wprowadzanieimg</td>
				<td class=dot>$modyfikacjaimg</td>
				<td class=dot>$usuwanieimg</td>
				<td class=dot>$bezograniczenimg</td>
				</tr>
				";
				$odczytimg = "";
				$wprowadzanieimg = "";
				$wprowadzanie_arr[$idzaspap2] = "";
				$modyfikacjaimg = "";
				$usuwanieimg = "";
				$bezograniczenimg = "";
					
				}
			}





#	echo "
#	Papier 1:<br> O:$_POST[zaspap1odczyt] W- $_POST[zaspap1wprowadzanie] M- $_POST[zaspap1modyfikacja] U- $_POST[zaspap1usuwanie] B- $_POST[zaspap1bezograniczen] <br>
#	Papier 2:<br> O:$_POST[zaspap2odczyt] W- $_POST[zaspap2wprowadzanie] M- $_POST[zaspap2modyfikacja] U- $_POST[zaspap2usuwanie] B- $_POST[zaspap2bezograniczen] <br> 
#	";
	}

if (($d == 2) || ($d == 3) || ($d == 4) || ($d == 6) || ($d == 7))
	{
	echo "

	<h4>Wnioski</h4>
	<table>
	<tr class=wn_top>
	<td class=dot>Nazwisko 
	</td>
	<td class=dot>Imie 
	</td>
	<td class=dot>Dzial</td>
	<td class=dot>Wniosek z³o¿y³
	</td>
	<td class=dot>Status
	</td>
	<td class=dot>Data z³o¿enia 
	</td>
	<td class=dot>Data zatwierdzenia 
	</td>
	<td class=dot>Data ostatniej <br> modyfikacji 
	</td>
	<td class=dot>Usuñ wniosek</td>
	</tr>
	<tr>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=nazwisko&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=nazwisko&set=down><img src=img/down.png border=0></a>
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=imie&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=imie&set=down><img src=img/down.png border=0></a>
	</td>
	<td class=dot>
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=zlozyl&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=zlozyl&set=down><img src=img/down.png border=0></a>	
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=status&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=status&set=down><img src=img/down.png border=0></a>
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datazlo&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datazlo&set=down><img src=img/down.png border=0></a>
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datazat&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datazat&set=down><img src=img/down.png border=0></a>
	</td>
	<td class=dot>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datamod&set=up><img src=img/up.png border=0></a>
	<a href=index.php?m=up&ddet=$d&det=2&sort=datamod&set=down><img src=img/down.png border=0></a>
	</td>
	</tr>	
	";
	$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	if ($sort == 'nazwisko') $sortqry = 'order by wnioski.nazwisko';
	if ($sort == 'imie') $sortqry = 'order by wnioski.imie';
	if ($sort == 'zlozyl') $sortqry = 'order by uzytkownicy.nazwa_u';
	if ($sort == 'status') $sortqry = 'order by wnioski.status_wn';	
	if ($sort == 'datazlo') $sortqry = 'order by wnioski.data_zl';
	if ($sort == 'datazat') $sortqry = 'order by wnioski.data_zat';
	if ($sort == 'datamod') $sortqry = 'order by wnioski.data_mod';
	if (!$sort) $sortqry = 'order by wnioski.data_zl';
	if ($set == 'down') $setqry = 'desc';
	if ($set == 'up') $setqry = 'asc';
	if (!$set) $setqry = 'desc';

	$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	if ($wniosek_user == 'ni')
		{
		if ($d == 2) {$where_status = '';}
		if ($d == 3) {$where_status = 'where wnioski.status_wn = 9';}
		if ($d == 6) {$where_status = 'where wnioski.status_wn = 11';}
		if ($d == 6) {$where_status = 'where wnioski.status_wn = 11';}
		if ($d == 7) {$where_status = 'where wnioski.status_wn = 1 or wnioski.status_wn = 4 or wnioski.status_wn = 10';}
		if ($d == 4) {$where_status = 'where wnioski.status_wn = 1 or wnioski.status_wn = 2 or wnioski.status_wn = 4 or wnioski.status_wn = 5 or 
		wnioski.status_wn = 3 or wnioski.status_wn = 12';}
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz $where_status
		$sortqry
		$setqry");
		}
	$ile_wnioskow=mysql_num_rows($pokaz_wnioski);
		if ($ile_wnioskow != 0)
			{
			for($i = 0; $i < $ile_wnioskow; $i++)
				{
				$wnioski=mysql_fetch_array($pokaz_wnioski);
				$status_fetch=$wnioski['status_wn'];
				echo "
				<tr $hover>
				<td class=dot><a href=index.php?m=up&det=pw&idwn=$wnioski[id_wn]>$wnioski[nazwisko]</a></td>
				<td class=dot><a href=index.php?m=up&det=pw&idwn=$wnioski[id_wn]>$wnioski[imie]</a></td>
				<td class=dot>$wnioski[symbol_d]</td>
				<td class=dot>$wnioski[nazwa_u] $wnioski[imie_u]</td>
				<td class=dot>$status[$status_fetch]</td>
				<td class=dot>$wnioski[data_zl]</td>
				<td class=dot>$wnioski[data_zat]</td>
				<td class=dot>$wnioski[data_mod]</td>
				<td class=dot><a href=index.php?m=up&det=uw&idwn=$wnioski[id_wn] onclick=\"return confirm
				('Czy na pewno chcesz usun±æ wniosek dla $wnioski[imie] $wnioski[nazwisko] ?')\">
				<img src=img/drop.png></a></td>
				</tr>
				";
				}
			}
	echo "</table>";
	}

if (($det == 'pw') || ($det == 'dozmwn'))
	{
	$det_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$det_wniosek=mysql_db_query("ewidencja", "select nazwisko, imie, status_wn, data_od, data_do from wnioski where id_wn = '$idwn'");
	$wniosek=mysql_fetch_array($det_wniosek);
	echo "
	<h2>Szczegó³y wniosku:</h2>
	Imiê: <b>$wniosek[imie]</b><br>
	Nazwisko: <b>$wniosek[nazwisko]</b><br>
	Obowi±zuje od: <b>$wniosek[data_od]</b><br>
	Obowi±zuje do: <b>$wniosek[data_do]</b><br>
	";
	if ($d_delete == 1)
		{
		$glowna = getcwd(); // Save the current directory
   		chdir(dokumenty);
    		if ($odw_dok != 1)	{rename($dok, "usuniete\\$dok");}
    		if ($odw_dok == 1)	
		{
		chdir("odwolania");
		rename($dok, "usuniete\\$dok");
		}
		chdir($glowna); // Restore the old working directory
		$usun_dok_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$usun_dok=mysql_db_query("ewidencja", "delete from dokumenty_wnioski where link_dok = '$dok'");
		}
	
	if ($d_add == 2)
		{
		$plik_tmp = $_FILES['skanwn']['tmp_name']; 
		$plik_nazwa = $_FILES['skanwn']['name']; 
		$plik_rozmiar = $_FILES['skanwn']['size']; 
		#echo $_FILES['skanwn']['error'];
	if(is_uploaded_file($plik_tmp)) 
	{ 
  	  $uniq = uniqid();
	$b=substr($plik_nazwa, -5, 5);
	$nowanazwa = array($wniosek[nazwisko], $wniosek[imie], $uniq, $b);
	$nowy_plik2 = implode('_', $nowanazwa);
	$nowy_plik3 = str_replace(' ', '',$nowy_plik2);
	$nowy_plik = _no_pl($nowy_plik3);
	move_uploaded_file($plik_tmp, "dokumenty/$nowy_plik");
	$d_add_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$query_d_add=mysql_db_query("ewidencja", "insert into dokumenty_wnioski (link_dok, id_wn) values ('$nowy_plik', '$idwn')");
	#$query_status=mysql_db_query("ewidencja", "update wnioski set status_wn = 9");
	}
	} 
	echo "
	Dokumenty:<br>
	";
	$dok_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$pokaz_dok=mysql_db_query("ewidencja", "select  *  from dokumenty_wnioski where id_wn = '$idwn'");
	$ile_dok=mysql_num_rows($pokaz_dok);
	
	for($i = 0; $i < $ile_dok; $i++)
		{
		$wyswietl_dok = mysql_fetch_array($pokaz_dok);
		if ($wyswietl_dok[typ_dok] == 2) 
			{
			$odwolania = "odwolania/";
			echo "
			<a href=dokumenty/$odwolania$wyswietl_dok[link_dok]  target='_blank' title=' podgl±d pliku $wyswietl_dok[link_dok]'><img src=img/dokument.jpg></a>
			";
			if ($wniosek[status_wn] == 5)
				{
				echo "
				<a href=index.php?m=up&det=pw&idwn=$idwn&odw_dok=1&d_delete=1&dok=$wyswietl_dok[link_dok]  title=' usuñ plik $wyswietl_dok[link_dok]'
				onclick=\"return confirm('Czy na pewno chcesz usun±æ ten plik?')\"><img src=img/delete.gif></a>
				&nbsp; &nbsp; <br>
				";
				}		
			}	
		if ($wyswietl_dok[typ_dok] != 2) 
			{
			echo "
			<a href=dokumenty/$odwolania$wyswietl_dok[link_dok]  target='_blank' title=' podgl±d pliku $wyswietl_dok[link_dok]'><img src=img/dokument.jpg></a>
			";
			if ($wniosek[status_wn] == 5)
				{
				echo "
				<a href=index.php?m=up&det=pw&idwn=$idwn&d_delete=1&dok=$wyswietl_dok[link_dok]  title=' usuñ plik $wyswietl_dok[link_dok]'
				onclick=\"return confirm('Czy na pewno chcesz usun±æ ten plik?')\"><img src=img/delete.gif></a>
				&nbsp; &nbsp; <br>
				";
				}	
			}
		}
	if (($wniosek[status_wn] == 5) && ($d_add != 1) && ($ile_dok == 0))
		{
		echo "
		<form action=index.php?m=up&m=up&det=pw&idwn=$idwn&d_add=1 method=post>
		<input type=submit name=dodaj value='do³±cz skan wniosku' >
		</form>
		";
		}
	if (($wniosek[status_wn] == 5) && ($d_add == 1))
		{
		echo "
		</td>
		<td>
		<form action=index.php?m=up&m=up&det=pw&idwn=$idwn&d_add=2 enctype='multipart/form-data' method=post>
		<input type=hidden name='MAX_FILE_SIZE' value=5000000>
		<input type=file name=skanwn>
		<input type=submit name=dodaj value='do³±cz skan wniosku' >
		</form>
		</td>
		";
		}
	
	echo "
	<hr><br>
	<h2>Zasoby papierowe</h2>
	<table class=dot>
	<tr>
	<td class=dot>Nazwa zasobu</td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
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
								
				if ($zaspap[odczyt] == 1) {$odczytimg = "<img src=img/checked.gif>";}
				if ($zaspap[wprowadzanie] == 1) {$wprowadzanieimg = "<img src=img/checked.gif>";}
				if ($zaspap[modyfikacja] == 1) {$modyfikacjaimg = "<img src=img/checked.gif>";}
				if ($zaspap[usuwanie] == 1) {$usuwanieimg = "<img src=img/checked.gif>";}
				if ($zaspap[bezograniczen] == 1) {$bezograniczenimg = "<img src=img/checked.gif>";}
				
				
				
				echo "
				<tr $hover>
				<td class=dot>$zaspap[nazwa_zaspap]</td>
				<td class=dot>$odczytimg</td>
				<td class=dot>$wprowadzanieimg</td>
				<td class=dot>$modyfikacjaimg</td>
				<td class=dot>$usuwanieimg</td>
				<td class=dot>$bezograniczenimg</td>
				</tr>
				";
				$odczytimg = "";
				$wprowadzanieimg = "";
				$modyfikacjaimg = "";
				$usuwanieimg = "";
				$bezograniczenimg = "";
				}
			echo "
			</table>
			<hr>
			<br>
			<h2>Systemy, programy, aplikacje</h2>
			<table class=dot>
			<tr>
			<td class=dot>Nazwa systemu</td>
			<td class=dot>Nazwa modu³u</td>
			<td class=dot>Zakres stanowiska</td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Login</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Pocz±tkowe has³o</div></td>
			</tr>
			";
			
	
		$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.nazwa_sys, systemy.id_sys, moduly.id_mod, moduly.nazwa_mod, 
		uprawnienia.id_st, uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen, 
		uprawnienia.login_mod, uprawnienia.haslo_mod, stanowiska_lista.stanowisko 
		from uprawnienia 
		left join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on systemy.id_sys = moduly.id_sys
		left join stanowiska_lista
		on stanowiska_lista.id_st = uprawnienia.id_st
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_mod > 0");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		if (($wniosek_user == 'ni') && (($wniosek[status_wn] == '1') || ($wniosek[status_wn] == '4')) && ($det != 'dozmwn'))
			{
			echo "
			<form action=index.php?m=up&det=zatwn&idwn=$idwn method=post>
			";
			}
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				if ($sysmod[odczyt] == 1) {$odczytimg = "<img src=img/checked.gif>";}
				if ($sysmod[wprowadzanie] == 1) {$wprowadzanieimg = "<img src=img/checked.gif>";}
				if ($sysmod[modyfikacja] == 1) {$modyfikacjaimg = "<img src=img/checked.gif>";}
				if ($sysmod[usuwanie] == 1) {$usuwanieimg = "<img src=img/checked.gif>";}
				if ($sysmod[bezograniczen] == 1) {$bezograniczenimg = "<img src=img/checked.gif>";}
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadznie_sysmod_arr). "<br>";
				if ((($sysmod[odczyt] == 1) || ($sysmod[wprowadzanie] == 1) || ($sysmod[modyfikacja] == 1)
				|| ($sysmod[usuwanie] == 1) || ($sysmod[bezograniczen] == 1)) && ($det == 'pw'))
					{
					if (($wniosek[status_wn] == 1) || ($wniosek[status_wn] == 4))
						{
						$loginmod = "<input size=10 type=text name='loginmod[$idsysmod]'>";
						$haslomod = "<input size=10 type=text name='haslomod[$idsysmod]'>";
						}
					if (($wniosek[status_wn] != 1) && ($wniosek[status_wn] != 4))
						{
						$loginmod = "&nbsp;$sysmod[login_mod]&nbsp;";
						$haslomod = "&nbsp;$sysmod[haslo_mod]&nbsp;";
						}
					
					}
				if (($sysmod[odczyt] == 0) && ($sysmod[wprowadzanie] == 0) && ($sysmod[modyfikacja] == 0)
				&& ($sysmod[usuwanie] == 0) && ($sysmod[bezograniczen] == 0))
					{
					$loginmod = "";
					$haslomod = "";
					}
				echo "
				<tr $hover>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
				<td class=dot>$sysmod[stanowisko]</td>
				<td class=dot>$odczytimg</td>
				<td class=dot>$wprowadzanieimg</td>
				<td class=dot>$modyfikacjaimg</td>
				<td class=dot>$usuwanieimg</td>
				<td class=dot>$bezograniczenimg</td>
				<td class=dot>$loginmod</td>
				<td class=dot>$haslomod</td>
				</tr>
				";
				$odczytimg = '';
				$wprowadzanieimg = '';
				$modyfikacjaimg = '';
				$usuwanieimg = '';
				$bezograniczenimg = '';
				}
	
		echo "
		</table>
		<hr>
		<br>
		";
		
		if (($wniosek_user == 'ni') && (($wniosek[status_wn] == '1') || ($wniosek[status_wn] == '3') || ($wniosek[status_wn] == '4')) && ($det != 'dozmwn'))
			{
			$uwaga_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jaka_uwaga=mysql_db_query("ewidencja", "select * from uwagi_wn where id_wn = '$idwn'");
			$ile_uwag=mysql_num_rows($jaka_uwaga);
			echo "
			<table>
			";
			for($i = 0; $i < $ile_uwag; $i++)
				{
				$uwaga=mysql_fetch_array($jaka_uwaga);
				echo"
				<tr>
				<td>
				$uwaga[data_uw]
				</td>
				<td>
				$uwaga[uwaga]
				</td>
				</tr>
					";
				}
			
			echo "
			<tr>
			<td>
			<a href=index.php?m=up&m=up&det=dozmwn&idwn=$idwn>
			Wniosek do zmiany
			</a>
			</td>
			<td>
			
			<input type=submit name='zatwn' value='zatwierd¼ wniosek'>
			</form>
			</td>
			</tr>
			</table>
			";
			}
		if (($det == 'dozmwn') && ($wniosek_user == 'ni'))
			{
			echo "
			<form action=index.php?m=upm=up& method=post>
			<textarea name=uwagawn cols=50 rows=10>Uwagi:
			</textarea>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=dopoprawy value='zg³o¶ do poprawy'>
			</form>
			";
			}
		if ((($wniosek[status_wn] == 5) || ($wniosek[status_wn] == 4)) && (($ile_dok > 0)))
			{
			echo "
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=checkbox name=insertnewuser value=1> Stwórz urzytkownika w bazie<br>
			";
			$uzytkownicy=mysql_db_query("ewidencja", "select uzytkownicy.id_u, uzytkownicy.nazwa_u, uzytkownicy.imie_u, 
			dokumenty_wnioski.typ_dok
			from uzytkownicy
			left join dokumenty_wnioski
			on dokumenty_wnioski.id_wn = uzytkownicy.id_wn
			where uzytkownicy.id_wn is NULL 
			or uzytkownicy.id_wn = 0 
			or dokumenty_wnioski.typ_dok = 1 
			order by nazwa_u asc");
			$ile_uzytkownikow=mysql_num_rows($uzytkownicy);
			if ($ile_uzytkownikow > 0)
				{
				echo "
				Po³±cz z istniej±cym u¿ytkownikiem: <select name=uzytkownik>
				<option value=0> --- </option> 
				";
				for($j = 0; $j < $ile_uzytkownikow; $j++)
					{
					$uzytkownik=mysql_fetch_array($uzytkownicy);
					echo "
					<option value='$uzytkownik[id_u]'>$uzytkownik[nazwa_u] $uzytkownik[imie_u]</option>
					";
					}
				echo "
				</select>
				";
				}

			echo "
			<br>
			<input type=checkbox name=sendmailcheckbox value=1> Nie wysy³aj powiadomienia<br>
			<input type=submit name=zakonczwniosek value='zakoñcz wniosek'>
			</form>
			";
			}
		if (($wniosek_user == 'ni') && ($wniosek[status_wn] == '10'))
			{
			echo "
			<form action=index.php?m=up& method=post>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=hidden name=d value=2>
			<input type=submit name=odwwn value='odwo³aj wniosek'>
			</form>
			";
			}
		}
if ($det == 'addzaspap2')
	{
	$addzaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$iddzquery=mysql_db_query("ewidencja", "select * from dzialy where symbol_d = '$department'");
	$iddzfetch=mysql_fetch_array($iddzquery);
	$iddzfind=$iddzfetch[id_dz];
	$addzaspap=mysql_db_query("ewidencja", "insert into zasoby_papierowe (id_pok, id_dz, nazwa_zaspap)
	values ('$idpok', '$iddzfind', '$nazwazaspap')");
	$d=5;
	}
if ($d == 5)
	{
	echo "
	<br>
	<br>
	<table>
	<tr>
	<td width=80% class=topdot>Nazwa zasobu</td>
	<td class=topdot>Nr pokoju</td>
	<td class=topdot>Edytuj</td>
	</tr>
	";
	
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap  
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		echo "
		<tr $hover>
		<td>$zaspap[nazwa_zaspap]</td>
		<td>$zaspap[id_pok]</td>
		<td><a href=index.php?m=up&det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
		</tr>
		";
		}
	echo "
	<form action=index.php?m=up&det=addzaspap method=post>
	<tr>
	<td>
	<input type=submit name=dodaj value='Dodaj zasób papierowy'>
	</td>
	</tr>
	</form>
	</table>
	";
	
	}
if ($det == 'edzaspap')
	{
	echo "
	<br>
	<table>
	<tr>
	<td class=topdot>Nazwa zasobu</td>
	<td class=topdot>Nr pokoju</td>
	<td class=topdot>Edytuj</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap  
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		if ($zaspap[id_zaspap] != $idzaspap)
			{
			echo "
			<tr $hover>
			<td width=80%>$zaspap[nazwa_zaspap]</td>
			<td>$zaspap[id_pok]</td>
			<td><a href=index.php?m=up&det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
			</tr>
			";
			}
		if ($zaspap[id_zaspap] == $idzaspap)
			{
			echo "
			
			<tr $hover>
			<td width=80%>
			<form action=index.php?m=up&det=edzaspap2&idzaspap=$idzaspap method=post>
			<input type=text name=nazwazaspap value='$zaspap[nazwa_zaspap]' size=80%>
			</td>			
			<td>
			";
			$jakie_pokoje=mysql_db_query("ewidencja", "select pokoje.id_pok from pokoje
			left join dzialy 
			on pokoje.id_dz = dzialy.id_dz");
			$ile_pokoi=mysql_num_rows($jakie_pokoje);
			if ($ile_pokoi > 0)
				{
				echo "
				<select name=idpok>
				";
				for($j = 0; $j < $ile_pokoi; $j++)
					{
					$pokoj=mysql_fetch_array($jakie_pokoje);
					echo "
					<option value='$pokoj[id_pok]'>$pokoj[id_pok]</option>
					";
					}
				echo "
				</select>
				";
				}

			echo "
			</td>
			<td><input type=submit name=popraw value='Popraw'></form></td>
			</tr>
			
			";
			}
		}
	echo "</table>";
	}
if ($det == 'edzaspap2')
	{
	echo "
	<br>
	<table>
	<tr>
	<td width=80% class=topdot>Nazwa zasobu</td>
	<td class=topdot>Nr pokoju</td>
	<td class=topdot>Edytuj</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$popraw_zaspap=mysql_db_query("ewidencja", "update zasoby_papierowe set nazwa_zaspap = '$nazwazaspap', id_pok = '$idpok' where id_zaspap = '$idzaspap'");
	mysql_close($jakie_zaspap_connect);
	$edit_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap  
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		if ($zaspap[id_zaspap] != $idzaspap)
			{
			echo "
			<tr $hover>
			<td width=80%>$zaspap[nazwa_zaspap]</td>
			<td>$zaspap[id_pok]</td>
			<td><a href=index.php?m=up&det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
			</tr>
			";
			}
		}	
	echo "</table>";
	}
if ($det == 'addzaspap')
	{
	echo "
	<br>
	<table>
	<tr>
	<td class=topdot>Nazwa zasobu</td>
	<td class=topdot>Nr pokoju</td>
	<td class=topdot>Edytuj</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap  
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		echo "
		<tr $hover>
		<td>$zaspap[nazwa_zaspap]</td>
		<td>$zaspap[id_pok]</td>
		<td><a href=index.php?m=up&det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
		</tr>
		";
		}
	echo "
	<form action=index.php?m=up&det=addzaspap2 method=post>
	<tr>
	<td><input type=text name=nazwazaspap size=100%></td>			
	<td>
	";
	$jakie_pokoje=mysql_db_query("ewidencja", "select pokoje.id_pok from pokoje
	left join dzialy 
	on pokoje.id_dz = dzialy.id_dz");
	$ile_pokoi=mysql_num_rows($jakie_pokoje);
	if ($ile_pokoi > 0)
		{
		echo "
		<select name=idpok>
		";
		for($j = 0; $j < $ile_pokoi; $j++)
			{
			$pokoj=mysql_fetch_array($jakie_pokoje);
			echo "
			<option value='$pokoj[id_pok]'>$pokoj[id_pok]</option>
			";
			}
		echo "
		</select>
		";
		}
	echo "
	</td>
	<td><input type=submit name=popraw value='Dodaj zasób papierowy'></td>
	</tr>
	</form>
	</table>

	";
	}
	
if ($d == 8)
	{
	echo "
	<h3> Systemy i Modu³y</h3>
	<table>
	<tr>
	<td>Nazwa zbioru</td>
	<td>Nazwa systemu</td>
	<td>Nazwa modu³u</td>
	<td>Aktywny</td>
	<td>odczyt</td>
	<td>wprowadzanie</td>
	<td>modyfikacja</td>
	<td>usuwanie</td>
	<td>bez ograniczeñ</td>
	<tr>	
	";
	
	
	$jakie_sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_sysmod=mysql_db_query("ewidencja", "select zbiory_do.id_zb, zbiory_do.skrnazwa_zb, systemy.id_sys, systemy.nazwa_sys, moduly.id_mod, moduly.nazwa_mod, 
	uprawnienia_default.odczyt, uprawnienia_default.wprowadzanie, uprawnienia_default.modyfikacja, uprawnienia_default.usuwanie, uprawnienia_default.bez_ograniczen, moduly.mod_enable 
	from zbiory_do 
	left join moduly
	on zbiory_do.id_zb = moduly.id_zb
	left join systemy
	on systemy.id_sys = moduly.id_sys
	left join uprawnienia_default
	on moduly.id_mod = uprawnienia_default.id_mod
	order by systemy.id_sys, moduly.id_sys");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	mysql_close($jakie_sysmod_connect);
	for($i = 0; $i < $ile_sysmod; $i++)
		{
		$sysmod=mysql_fetch_array($jakie_sysmod);
		if ($sysmod[odczyt] == 1) $stan_odczyt = "<img src=img/checked.gif>";
		if ($sysmod[odczyt] != 1) $stan_odczyt = "";
		if ($sysmod[wprowadzanie] == 1) $stan_wprowadzanie = "<img src=img/checked.gif>";
		if ($sysmod[wprowadzanie] != 1) $stan_wprowadzanie = "";
		if ($sysmod[modyfikacja] == 1) $stan_modyfikacja = "<img src=img/checked.gif>";
		if ($sysmod[modyfikacja] != 1) $stan_modyfikacja = "";
		if ($sysmod[usuwanie] == 1) $stan_usuwanie = "<img src=img/checked.gif>";
		if ($sysmod[usuwanie] != 1) $stan_usuwanie = "";
		if ($sysmod[bez_ograniczen] == 1) $stan_bezograniczen = "<img src=img/checked.gif>";
		if ($sysmod[bez_ograniczen] != 1) $stan_bezograniczen = "";
		if ($sysmod[mod_enable] == 1) $stan_mod_enable = "<img src=img/checked.gif>";
		if ($sysmod[mod_enable] != 1) $stan_mod_enable = "";
		echo "
		<tr $hover>
		<td><a href=?det=pzb&idzbget=$sysmod[id_zb]>$sysmod[skrnazwa_zb]</a></td>
		<td><a href=?det=psys&idsysget=$sysmod[id_sys]>$sysmod[nazwa_sys]</td>
		<td><a href=?det=pmod&idmodget=$sysmod[id_mod]>$sysmod[nazwa_mod]</td>
		<td>$stan_mod_enable</td>
		<td>$stan_odczyt</td>
		<td>$stan_wprowadzanie</td>    
		<td>$stan_modyfikacja</td>
		<td>$stan_usuwanie</td>
		<td>$stan_bezograniczen</td>
		</tr>
		";
		}
	echo "</table>";
	
	}

if (($editzb) && ($nazwazb != '') && ($skrnazwazb != ''))
	{
	$edit_zb_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$edit_zb=mysql_db_query("ewidencja", "update zbiory_do set nazwa_zb = '$nazwazb', skrnazwa_zb = '$skrnazwazb'
	where id_zb = '$idzbget'");
	$det='pzb';
	}

if ($det == pzb)
	{
	$pokaz_zb_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$pokaz_zb=mysql_db_query("ewidencja", "select zbiory_do.id_zb, zbiory_do.nazwa_zb, zbiory_do.skrnazwa_zb
	from zbiory_do 
	where id_zb = $idzbget
	");
	
	echo "
	<h3>Podgl±d i edycja Zbioru Danych</h3>
	<table>
	<tr>
	<td>Nazwa zbioru danych</td>
	<td>Skrócona nazwa zbioru</d>
	<td>Edycja</td>
	<td>Kasowanie</td>
	</tr>
	
	";
	
	$ile_zb=mysql_num_rows($pokaz_zb);
	for($i = 0; $i < $ile_zb; $i++)
		{
		$zb=mysql_fetch_array($pokaz_zb);	
		echo "
		<tr>
		<td>
		<form action=?det=edit_zb&idzbget=$zb[id_zb] method=post>
		<input type=text name=nazwazb value='$zb[nazwa_zb]'>
		</td>
		<td>
		<input type=text name=skrnazwazb value='$zb[skrnazwa_zb]'>
		</td>
		<td>
		<input type=hidden name=d value=8>
		<input type=submit name=editzb value='edytuj zbiór'>
		</form>
		</td>
		<td><a href=?det=zb_delete>delete</a></td>
		</tr>
		";		
		}
	echo "
	</table>
	";
	}
	
	
if ($det == psys)
	{
	$pokaz_sys_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$pokaz_sys=mysql_db_query("ewidencja", "select systemy.id_sys, systemy.nazwa_sys
	from systemy 
	where id_sys = $idsysget
	");
	
	echo "
	<h3>Podgl±d i edycja systemu</h3>
	<table>
	<tr>
	<td>Nazwa systemu</td>
	<td>Edycja</td>
	<td>Kasowanie</td>
	</tr>
	";
	
	$ile_sys=mysql_num_rows($pokaz_sys);
	for($i = 0; $i < $ile_sys; $i++)
		{
		$sys=mysql_fetch_array($pokaz_sys);	
		echo "
		<tr>
		<td>
		<form action=?det=edit_sys&idsysget=$sys[id_sys] method=post>
		<input type=text name=nazwasys value='$sys[nazwa_sys]'>
		</td>
		<td>
		<input type=hidden name=d value=8>
		<input type=submit name=editsys value='edytuj system'>
		</form>
		</td>
		<td>delete</td>
		</tr>
		";		
		}
	echo "
	</table>
	";
	}
if (($editsys) && ($nazwasys != ''))
	{
	$edit_sys_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$edit_sys=mysql_db_query("ewidencja", "update systemy set nazwa_sys = '$nazwasys'
	where id_sys = '$idsysget'");
	
	echo "OK ! : $nazwasys !!! $idzbget !!!";
	}	

if ($det == edit_mod)
	{
	$edit_mod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$edit_mod1=mysql_db_query("ewidencja", "update moduly set nazwa_mod = '$nazwamod', mod_enable = '$mod_enable_mod'
	where id_mod = $idmodget
	");
	$chk_upr_def=mysql_db_query("ewidencja", "select * from uprawnienia_default where id_mod = $idmodget");
	$ile_upr_def=mysql_num_rows($chk_upr_def);
	if ($ile_upr_def == 1)
		{
		$edit_mod2=mysql_db_query("ewidencja", "update uprawnienia_default set 
		odczyt = '$odczyt_mod', 
		wprowadzanie = '$wprowadzanie_mod', 
		modyfikacja = '$modyfikacja_mod', 
		usuwanie = '$usuwanie_mod', 
		bez_ograniczen = '$bezograniczen_mod'
		where id_mod = '$idmodget'
		");
		}
	if ($ile_upr_def == 0)
		{
		$edit_mod2=mysql_db_query("ewidencja", "insert into uprawnienia_default  
		(id_mod, odczyt, wprowadzanie, modyfikacja, usuwanie, bez_ograniczen) values 
		('$idmodget', '$odczyt_mod', '$wprowadzanie_mod', '$modyfikacja_mod', '$usuwanie_mod', '$bezograniczen_mod')
		");
		}
	$det = 'pmod';
	}

if ($det == 'pmod')
	{
	$pokaz_mod_connect=mysql_connect("localhost", "root", "pwtychy");
	if ($stget_del > 0)
		{
		$del_st=mysql_db_query("ewidencja", "delete from stanowiska_moduly where id_st = $stget_del and id_mod = $idmodget");
		}
	if (($stget_add == 1) && ($stnamepost != ''))
		{
		$add_st=mysql_db_query("ewidencja", "insert into stanowiska_moduly (id_mod, id_st ) values ($idmodget, $stnamepost)");
		}
	$pokaz_mod=mysql_db_query("ewidencja", "select moduly.id_mod, moduly.nazwa_mod, moduly.mod_enable, uprawnienia_default.odczyt, 
	uprawnienia_default.wprowadzanie, uprawnienia_default.modyfikacja, uprawnienia_default.usuwanie, uprawnienia_default.bez_ograniczen
	from moduly
	left join
	uprawnienia_default
	on moduly.id_mod = uprawnienia_default.id_mod 
	where moduly.id_mod = $idmodget
	");
	
	echo "
	<h3>Podgl±d i edycja modu³u</h3>
	<table>
	<tr>
	<td>Nazwa modulu</td>
	<td>aktywny</td>
	<td>odczyt</td>
	<td>wprowadzanie</td>
	<td>modyfikacja</td>
	<td>usuwanie</td>
	<td>bez ograniczeñ</td>
	<td>Edycja</td>
	<td>Kasowanie</td>
	</tr>
	";
	
	$ile_mod=mysql_num_rows($pokaz_mod);
	for($i = 0; $i < $ile_mod; $i++)
		{
		$mod=mysql_fetch_array($pokaz_mod);	
		$idmod = $mod[id_mod];
		if ($mod[mod_enable] == 1) {$checked_mod_enable = 'checked=checked'; $mod_enableimg = "<img src=img/checked.gif>";}
		if ($mod[odczyt] == 1) {$checked_odczyt = 'checked=checked'; $odczytimg = "<img src=img/checked.gif>";}
		if ($mod[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked'; $wprowadzanieimg = "<img src=img/checked.gif>";}
		if ($mod[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked'; $modyfikacjaimg = "<img src=img/checked.gif>";}
		if ($mod[usuwanie] == 1) {$checked_usuwanie = 'checked=checked'; $usuwanieimg = "<img src=img/checked.gif>";}
		if ($mod[bez_ograniczen] == 1) {$checked_bezograniczen = 'checked=checked'; $bezograniczenimg = "<img src=img/checked.gif>";}
		echo "
		<tr>
		<td>
		<form action=?det=edit_mod&idmodget=$mod[id_mod] method=post>
		<input type=text name=nazwamod value='$mod[nazwa_mod]'>
		</td>
		<td>
		<input type=checkbox name='mod_enable_mod' value='1' $checked_mod_enable/>
		</td>
		<td>
		<input type=checkbox name='odczyt_mod' value='1' $checked_odczyt/>
		</td>
		<td>
		<input type=checkbox name='wprowadzanie_mod' value='1' $checked_wprowadzanie/>
		</td>
		<td>
		<input type=checkbox name='modyfikacja_mod' value='1' $checked_modyfikacja/>
		</td>
		<td>
		<input type=checkbox name='usuwanie_mod' value='1' $checked_usuwanie/>
		</td>
		<td>
		<input type=checkbox name='bezograniczen_mod' value='1' $checked_bezograniczen/>
		</td>
		<td>
		<input type=submit name='submit' value='Popraw modu³'>
		</td>
		<td>delete</td>
		</form>
		</td>
		</tr>
		<tr></tr>
		<tr>
		<td><h4>Stanowiska</h4></td>
		</tr>
		";
		$pokaz_st_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$pokaz_st=mysql_db_query("ewidencja", "select * from stanowiska_moduly 
		left join stanowiska_lista
		on stanowiska_moduly.id_st = stanowiska_lista.id_st
		where stanowiska_moduly.id_mod = $idmodget");
		$ile_st=mysql_num_rows($pokaz_st);
		for($j = 0; $j < $ile_st; $j++)
			{
			$st=mysql_fetch_array($pokaz_st);
			echo "
			<tr>
			<td>
			$st[stanowisko]
			</td>
			<td>
			<a href=?det=pmod&idmodget=$idmodget&stget_del=$st[id_st]>
			<img src=/wnioski/img/drop.png>
			</a>
			</td>
			</tr>
			";
			}
		echo "
		<tr>
		<td>
		<form action=?det=pmod&idmodget=$idmodget&stget_add=1 method=post>
		";
		$pokaz_st_lista=mysql_db_query("ewidencja", "select * from stanowiska_lista where id_st not in (select id_st from stanowiska_moduly where id_mod = '$idmodget]') ");
		$ile_st_lista=mysql_num_rows($pokaz_st_lista); 
		if ($ile_st_lista > 0) {echo "<select name=stnamepost>";}
		for($k = 0; $k < $ile_st_lista; $k++)
			{
			$st_lista=mysql_fetch_array($pokaz_st_lista);
			echo "
			<option value=$st_lista[id_st]>$st_lista[stanowisko]</option>
			";
			}
		echo "
		<input type=submit name='stnamesubmit' value='dodaj stanowisko'>
		</form>
		</td>
		<tr>
		";
		
	echo "
	</table>
	";
	}
}

if ($d == 9)
	{
	require('wniosek.ewidencja_upowaznien.php');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>