<?

echo "
	$menu	
	";
$hover="onMouseOver=\"this.style.backgroundColor='#E1EAFE'\"; onMouseOut=\"this.style.backgroundColor='transparent'\"";
if ($det==2) $d=$ddet;
if (!$d) {$d=1;}
if ($odw_up == '1') 
	{
	$d=3;
	$odw_up_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$odw_up_qry=mysql_db_query("ewidencja", "update wnioski set status_wn = '10', data_do = CURDATE(), data_mod = CURDATE() where id_wn = '$idwn'");
	require("mailtopnk1.php");
	mysql_close($odw_up_connect); 
	}
if (($d == 1) || ($d == 2) || ($d == 3) || ($d == 4) || ($d == 6))
	{
	echo "
	<br>
	<br>
	<br>
	<table>
	<tr class=wn_top>
	<td>Nazwisko 
	</td>
	<td>Imie 
	</td>
	<td>Dzial</td>
	<td>Wniosek z�o�y�
	</td>
	<td>Status
	</td>
	<td>Data z�o�enia 
	</td>
	<td>Data zatwierdzenia 
	</td>
	<td>Data ostatniej <br>modyfikacji 
	</td>
	<td></td>
	</tr>
	<tr>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=nazwisko&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=nazwisko&set=down><img src=img/down.png border=0></a>
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=imie&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=imie&set=down><img src=img/down.png border=0></a>
	</td>
	<td>
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=zlozyl&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=zlozyl&set=down><img src=img/down.png border=0></a>	
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=status&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=status&set=down><img src=img/down.png border=0></a>
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=datazlo&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=datazlo&set=down><img src=img/down.png border=0></a>
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=datazat&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=datazat&set=down><img src=img/down.png border=0></a>
	</td>
	<td>
	<a href=wniosek.php?ddet=$d&det=2&sort=datamod&set=up><img src=img/up.png border=0></a>
	<a href=wniosek.php?ddet=$d&det=2&sort=datamod&set=down><img src=img/down.png border=0></a>
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
	if ($wniosek_user == 'pnk')
		{
		if ($d == 1) {$where_status = 'where wnioski.status_wn = 5 or wnioski.status_wn = 12';}
		if ($d == 3) {$where_status = 'where wnioski.status_wn = 9';}
		if ($d == 4) {$where_status = 'where wnioski.status_wn != 1 and wnioski.status_wn != 3 and wnioski.status_wn != 4 ';}
		if ($d == 6) {$where_status = 'where wnioski.status_wn = 11';}
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz $where_status
		$sortqry
		$setqry");
				
		if ($d_delete == 1)
			{
			$glowna = getcwd(); // Save the current directory
   			chdir(dokumenty);
			chdir(odwolania	);
   		 	rename($dok, "usuniete\\$dok");
	   	 	chdir($glowna); // Restore the old working directory
			$usun_dok_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$usun_dok=mysql_db_query("ewidencja", "delete from dokumenty_wnioski where link_dok = '$dok' and typ_dok = 2");
			}
		if ($d_add == 2)
			{
			$plik_tmp = $_FILES['odwolanie']['tmp_name']; 
			$plik_nazwa = $_FILES['odwolanie']['name']; 
			$plik_rozmiar = $_FILES['odwolanie']['size']; 
			#echo $_FILES['odwolanie']['error'];
		if(is_uploaded_file($plik_tmp)) 
			{ 
   			$dane_dok=mysql_db_query("ewidencja", "select * from wnioski where id_wn = '$idwn'");
			$dane=mysql_fetch_array($dane_dok);
			$uniq = uniqid();
			$b=substr($plik_nazwa, -5, 5);
			$nowanazwa = array($dane[nazwisko], $dane[imie], $uniq, $b);
			$nowy_plik2 = implode('_', $nowanazwa);
			$nowy_plik3 = str_replace(' ', '',$nowy_plik2);
			$nowy_plik = _no_pl($nowy_plik3);
			move_uploaded_file($plik_tmp, "dokumenty/odwolania/$nowy_plik");
			$d_add_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$query_d_add=mysql_db_query("ewidencja", "insert into dokumenty_wnioski (link_dok, typ_dok, id_wn) values ('$nowy_plik', 2, '$idwn')");
			}
			}
		
		
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
				<td><a href=wniosek.druk.php?idwn=$wnioski[id_wn] onclick=this.target='_blank'>$wnioski[nazwisko]</a></td>
				<td><a href=wniosek.druk.php?idwn=$wnioski[id_wn] onclick=this.target='_blank'>$wnioski[imie]</a></td>
				<td>$wnioski[symbol_d]</td>
				<td>$wnioski[nazwa_u] $wnioski[imie_u]</td>
				<td>$status[$status_fetch]</td>
				<td>$wnioski[data_zl]</td>
				<td>$wnioski[data_zat]</td>
				<td>$wnioski[data_mod]</td>
				";
				mysql_query("SET NAMES latin2");
				$pokaz_dok=mysql_db_query("ewidencja", "select  *  from dokumenty_wnioski where id_wn = '$wnioski[id_wn]' and typ_dok = 2"); // and typ_dok = 2
				$ile_dok=mysql_num_rows($pokaz_dok);
				for($j = 0; $j < $ile_dok; $j++)
					{
					$wyswietl_dok = mysql_fetch_array($pokaz_dok);
					echo "
					<td><a href=dokumenty/odwolania/$wyswietl_dok[link_dok]  target='_blank' title=' podgl�d pliku $wyswietl_dok[link_dok]'>
					<img src=img/dokument.jpg></a>
					";
					if ($status_fetch != 10)
						{
						//echo "
						//<a href=wniosek.php?d_delete=1&idwn=$wnioski[id_wn]&dok=$wyswietl_dok[link_dok]  title=' usu� plik $wyswietl_dok[link_dok]'
						//onclick=\"return confirm('Czy na pewno chcesz usun�� ten plik?')\"><img src=img/delete.gif></a>
						//</td>
						//";
						}
					if ($status_fetch == 12)
						{
						echo "
						<td>
						<form action=wniosek.php?odw_up=1&idwn=$wnioski[id_wn] method=post>
						<input type=submit name=odwolaj value='odwo�aj upowa�nienie'>
						</form>
						</td>
						";		
						}
					}
		if (($wnioski[status_wn] == 12) && ($d_add != 1) && ($ile_dok == 0))
			{
			echo "
			<td>
			<form action=wniosek.php?d_add=1&idwn=$wnioski[id_wn] method=post>
			<input type=hidden name=d value=$d>
			<input type=submit name=dodaj value='do��cz skan odwo�ania' >
			</form>
			</td>
			";
			}
		if (($wnioski[status_wn] == 12) && ($d_add == 1) && ($idwn == $wnioski[id_wn]))
			{
			echo "
			<td>
			<form action=wniosek.php?d_add=2&idwn=$idwn enctype='multipart/form-data' method=post>
			<input type=hidden name='MAX_FILE_SIZE' value=5000000>
			<input type=file name=odwolanie>
			<input type=hidden name=d value=3>
			<input type=submit name=dodaj value='do��cz skan odwo�ania' >
			</form>
			</td>
			";
			}
				
				
				echo "
				</tr>
				";
				}
			}
	
	}

if (($det == 'pw') || ($det == 'dozmwn'))
	{
	$det_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$det_wniosek=mysql_db_query("ewidencja", "select nazwisko, imie, status_wn, full_zaspap, full_sysmod from wnioski where id_wn = '$idwn'");
	$wniosek=mysql_fetch_array($det_wniosek);
	if ($wniosek[status_wn] != 3)
		{
		echo "
		<h2>Szczeg�y wniosku:</h2>
		Imi�: $wniosek[imie]<br>
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
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ogranicze�</div></td>
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
				<tr $hover>
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
			<td>Nazwa modu�u</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ogranicze�</div></td>
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
				<tr $hover>
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
	
		#<A onclick="window.print();return false;" href=" "><b>DRUKUJ v.1</b></a>
		echo "
		</table>
		<hr>
		<a href=wniosek.druk.php?idwn=$idwn onclick=this.target='_blank'>Drukuj</a>
		<br><br>
		";
		
		if (($wniosek_user == 'ni') && ($wniosek[status_wn] == '1') && ($det != 'dozmwn'))
			{
			echo "
			<table>
			<tr>
			<td>
			<a href=wniosek.php?det=zatwn&idwn=$idwn style='target: _blank;'>Wniosek poprawny</a>	
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
			<input type=submit name=dopoprawy value='zg�o� do poprawy'>
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
		<td>Imi�</td>
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
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ogranicze�</div></td>
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
				<tr $hover>
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
			<td>Nazwa modu�u</td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ogranicze�</div></td>
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
				<tr $hover>
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
			<input type=submit name=dopoprawy value='zg�o� do poprawy'>
			</form>
			";
			}
		}
}

if ($d == 9)
	{
	require('wniosek.ewidencja_upowaznien.php');
	}		

?>