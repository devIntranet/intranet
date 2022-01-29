<?
echo "
	$menu	
	";

if ($zakonczwniosek)
	{
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '9', data_zat = CURDATE() where id_wn = '$idwnpost'");
	mysql_close($zatwn_connect);
	}
if ($odwwn) 
	{
	$odw_up_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$odw_up_qry=mysql_db_query("ewidencja", "update wnioski set status_wn = '11', data_mod = CURDATE() where id_wn = '$idwnpost'");
	mysql_close($odw_up_connect); 
	}
if (($det == 'zatwn') && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '2' where id_wn = '$idwn'");
	$jakie_sysmod=mysql_db_query("ewidencja", "select * from uprawnienia where id_wn = '$idwn' and id_mod > 0");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	for($i = 0; $i < $ile_sysmod; $i++)
		{
		$sysmod=mysql_fetch_array($jakie_sysmod);
		$idmod=$sysmod[id_mod];
		$idwn=$sysmod[id_wn];
		$dodaj_login=mysql_db_query("ewidencja", "update uprawnienia set login_mod = '$loginmod[$idmod]', haslo_mod= '$haslomod[$idmod]'
		where id_mod = $idmod and id_wn = '$idwn'");
		}
	}
if (($det == 'uw') && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$uw_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$uw=mysql_db_query("ewidencja", "delete from wnioski where id_wn = '$idwn'");
	}
		
if (($dopoprawy) && ($wniosek_user == 'ni'))
	{
	$d = 2;
	$dopoprawy_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$dopoprawy=mysql_db_query("ewidencja", "insert into uwagi_wn (id_wn, data_uw, uwaga) values ('$idwnpost', CURDATE(), '$uwagawn')");
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
	</table>
	<hr>
	<br>
	";
	$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe where id_dz = '$dzialy[id_dz]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	echo "
	<h4>Zakres Uprawnieñ (przetwarzania danych osobowych):</h4>
	<h5>1. Tradycyjna Ewidencja Zasobów Papierowych</h5>
	<table class=dot>
	<tr>
	<td class=dot><div style=' font-weight: bold;'>Nazwa zbioru</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold;text-align: left'>Bez ograniczeñ</div></td>
	</tr>
	";
	for($i = 0; $i < $ile_zaspap; $i++)
				{
				$zaspap=mysql_fetch_array($jakie_zaspap);
				$idzaspap = $zaspap[id_zaspap];
				echo "
				<tr>
				<td class=dot>$zaspap[nazwa_zaspap]</td>
				<td class=dot><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='wprowadznie_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1'/></td>
				<td class=dot><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1'/></td>
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
	<table class=dot>
	<tr>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Systemu /<br> Programu / Aplikacji</div></td>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Modu³u</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
	</tr>
	";
	for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				echo "
				<tr>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
				<td class=dot><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1'/></td>
				<td class=dot><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1'/></td>
				<td class=dot><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1'/></td>
				<td class=dot><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1'/></td>
				<td class=dot><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1'/></td>
				</tr>
				";
				}
	echo "
	</table>
	<hr>
	<br>
	<input type=submit name=wyslijwniosek value='z³ó¼ wniosek'>
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
	<h2>Poda³e¶ dane:</h2>
	Imiê: $imie<br>
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
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
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
			<td>Nazwa modu³u</td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
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
	<td>Wniosek z³o¿y³</td>
	<td>Status</td>
	<td>Data z³o¿enia</td>
	<td>Data zatwierdzenia</td>
	<td>Data modyfikacji</td>
	<td>Usuñ wniosek</td>
	</tr>
	";
	$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
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
				<td><a href=wniosek.php?det=uw&idwn=$wnioski[id_wn] onclick=\"return confirm
				('Czy na pewno chcesz usun±æ wniosek dla $wnioski[imie] $wnioski[nazwisko] ?')\">
				<img src=img/drop.png></a></td>
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
	echo "
	<h2>Szczegó³y wniosku:</h2>
	Imiê: $wniosek[imie]<br>
	Nazwisko: $wniosek[nazwisko]<br>
	";
	if ($d_delete == 1)
		{
		$glowna = getcwd(); // Save the current directory
   		chdir(dokumenty);
    	rename($dok, "usuniete\\$dok");
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
	$nowy_plik = str_replace(' ', '',$nowy_plik2);
	move_uploaded_file($plik_tmp, "dokumenty/$nowy_plik");
	$d_add_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$query_d_add=mysql_db_query("ewidencja", "insert into dokumenty_wnioski (link_dok, id_wn) values ('$nowy_plik', '$idwn')");
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
		echo "
		<a href=dokumenty/$wyswietl_dok[link_dok]  target='_blank' title=' podgl±d pliku $wyswietl_dok[link_dok]'><img src=img/dokument.jpg></a>
		<a href=wniosek.php?det=pw&idwn=$idwn&d_delete=1&dok=$wyswietl_dok[link_dok]  title=' usuñ plik $wyswietl_dok[link_dok]'
		onclick=\"return confirm('Czy na pewno chcesz usun±æ ten plik?')\"><img src=img/delete.gif></a>
		&nbsp; &nbsp; <br>
		";		
		}
	if (($wniosek[status_wn] == 2) && ($d_add != 1) && ($ile_dok == 0))
		{
		echo "
		<form action=wniosek.php?det=pw&idwn=$idwn&d_add=1 method=post>
		<input type=submit name=dodaj value='do³±cz skan wniosku' >
		</form>
		";
		}
	if (($wniosek[status_wn] == 2) && ($d_add == 1))
		{
		echo "
		</td>
		<td>
		<form action=wniosek.php?det=pw&idwn=$idwn&d_add=2 enctype='multipart/form-data' method=post>
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
				<tr>
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
		uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen, 
		uprawnienia.login_mod, uprawnienia.haslo_mod
		from uprawnienia 
		left join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on systemy.id_sys = moduly.id_sys
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_mod > 0");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		if (($wniosek_user == 'ni') && (($wniosek[status_wn] == '1') || ($wniosek[status_wn] == '4')) && ($det != 'dozmwn'))
			{
			echo "
			<form action=wniosek.php?det=zatwn&idwn=$idwn method=post>
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
				<tr>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
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
		
		if (($wniosek_user == 'ni') && (($wniosek[status_wn] == '1') || ($wniosek[status_wn] == '4')) && ($det != 'dozmwn'))
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
			<a href=wniosek.php?det=dozmwn&idwn=$idwn>
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
			<form action=wniosek.php method=post>
			<textarea name=uwagawn cols=50 rows=10>Uwagi:
			</textarea>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=dopoprawy value='zg³o¶ do poprawy'>
			</form>
			";
			}
		if ((($wniosek[status_wn] == 2) || ($wniosek[status_wn] == 4)) && (($ile_dok > 0)))
			{
			echo "
			<form action=wniosek.php method=post>
			<input type=hidden name=d value=2>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=zakonczwniosek value='zakoñcz wniosek'>
			</form>
			";
			}
		if (($wniosek_user == 'ni') && ($wniosek[status_wn] == '10'))
			{
			echo "
			<form action=wniosek.php method=post>
			<input type=hidden name=idwnpost value=$idwn>
			<input type=hidden name=d value=2>
			<input type=submit name=odwwn value='odwo³aj wniosek'>
			</form>
			";
			}
		
		}
		
?>