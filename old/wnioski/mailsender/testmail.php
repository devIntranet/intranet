<?

echo "
	$menu	
	";
if (($det == 'zmwn') && ($wniosek_user == 'kxx'))
	{
	$d = 2;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '1' where id_wn = '$idwnpost'");
	require_once("phpmailer/class.phpmailer.php");
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
	<tr>
	<td>Obowi±zuje do</td>
	<td><input type=date name=datado maxlenght=10></td>
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
				
		<table>
		
		</table>
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
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
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
if (($det == 'dw') || ($det == 'popw'))
	{
	$insert_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");

	if ($det == 'dw')
		{
		if ($datado)
			{
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od, data_do) 
			values ('$nazwisko', '$imie', '$user_dzial[id_dz]', '$user_dzial[id_u]', 1, CURDATE(), CURDATE(), '$datado')");
			}
		if (!$datado)
			{
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od) 
			values ('$nazwisko', '$imie', '$user_dzial[id_dz]', '$user_dzial[id_u]', 1, CURDATE(), CURDATE())");
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
					<tr>
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
				(id_mod, odczyt, wprowadzanie, modyfikacja, usuwanie, bezograniczen, id_wn) 
				values ('$idsysmod2', '$odczyt_sysmod_arr[$idsysmod2]', '$wprowadzanie_sysmod_arr[$idsysmod2]',
				'$modyfikacja_sysmod_arr[$idsysmod2]', '$usuwanie_sysmod_arr[$idsysmod2]',
				'$bezograniczen_sysmod_arr[$idsysmod2]', '$auto_inc_id')");
				if ($odczyt_sysmod_arr[$idsysmod2] == 1) $odczytimg = "<img src=img/checked.gif>";
				if ($wprowadzanie_sysmod_arr[$idsysmod2] == 1) $wprowadzanieimg = "<img src=img/checked.gif>";
				if ($modyfikacja_sysmod_arr[$idsysmod2] == 1) $modyfikacjaimg = "<img src=img/checked.gif>";
				if ($usuwanie_sysmod_arr[$idsysmod2] == 1) $usuwanieimg = "<img src=img/checked.gif>";
				if ($bezograniczen_sysmod_arr[$idsysmod2] == 1) $bezograniczenimg = "<img src=img/checked.gif>";
				
				echo "
				<tr>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
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
					set odczyt = '$odczyt_arr[$idsysmod2]',
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
				<tr>
				<td class=dot>$sysmod[nazwa_sys]</td>
				<td class=dot>$sysmod[nazwa_mod]</td>
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
	<td>Data ostatniej modyfikacji</td>
	</tr>
	";
	$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
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

		echo "
		<h2>Szczegó³y wniosku:</h2>
		Imiê: $wniosek[imie]<br>
		Nazwisko: $wniosek[nazwisko]
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
		<form action=wniosek.php?det=popw method=post>
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
				#echo var_dump($wprowadzanie_arr). "<br>";
				if ($zaspap[odczyt] == 1) {$checked_odczyt = 'checked=checked'; $odczytimg = "<img src=img/checked.gif>";}
				if ($zaspap[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked'; $wprowadzanieimg = "<img src=img/checked.gif>";}
				if ($zaspap[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked'; $modyfikacjaimg = "<img src=img/checked.gif>";}
				if ($zaspap[usuwanie] == 1) {$checked_usuwanie = 'checked=checked'; $usuwanieimg = "<img src=img/checked.gif>";}
				if ($zaspap[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked'; $bezograniczenimg = "<img src=img/checked.gif>";}
				if ($wniosek[status_wn] == '3')
							
					{
					echo "
					<tr>
					<td class=dot>$zaspap[nazwa_zaspap]</td>
					<td class=dot><input type=checkbox name='odczyt_zaspap[$idzaspap2]' value='1' $checked_odczyt/></td>
					<td class=dot><input type=checkbox name='wprowadzanie_zaspap[$idzaspap2]' value='1' $checked_wprowadzanie/></td>
					<td class=dot><input type=checkbox name='modyfikacja_zaspap[$idzaspap2]' value='1' $checked_modyfikacja/></td>
					<td class=dot><input type=checkbox name='usuwanie_zaspap[$idzaspap2]' value='1' $checked_usuwanie/></td>
					<td class=dot><input type=checkbox name='bezograniczen_zaspap[$idzaspap2]' value='1' $checked_bezograniczen/></td>
					</tr>
					";
					$checked_odczyt = '';
					$checked_wprowadzanie = '';
					$checked_modyfikacja = '';
					$checked_usuwanie = '';
					$checked_bezograniczen = '';
					}
				if ($wniosek[status_wn] != '3')
					{
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
			<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
			<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
			<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
			<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
			<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
			";
			if ($wniosek[status_wn] == 9)
				{
				echo "
				<td class=dot>Login</td>
				<td class=dot>Has³o pocz±tkowe</td>
				";
				}
			echo "
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
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				if ($sysmod[odczyt] == 1) {$checked_odczyt = 'checked=checked'; $odczytimg = "<img src=img/checked.gif>";}
				if ($sysmod[wprowadzanie] == 1) {$checked_wprowadzanie = 'checked=checked'; $wprowadzanieimg = "<img src=img/checked.gif>";}
				if ($sysmod[modyfikacja] == 1) {$checked_modyfikacja = 'checked=checked'; $modyfikacjaimg = "<img src=img/checked.gif>";}
				if ($sysmod[usuwanie] == 1) {$checked_usuwanie = 'checked=checked'; $usuwanieimg = "<img src=img/checked.gif>";}
				if ($sysmod[bezograniczen] == 1) {$checked_bezograniczen = 'checked=checked'; $bezograniczenimg = "<img src=img/checked.gif>";}
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadzanie_sysmod_arr). "<br>";
				if ($wniosek[status_wn] == '3')
					{
					echo "
					<tr>
					<td class=dot>$sysmod[nazwa_sys]</td>
					<td class=dot>$sysmod[nazwa_mod]</td>
					<td class=dot><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' $checked_odczyt/></td>
					<td class=dot><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1' $checked_wprowadzanie/></td>
					<td class=dot><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' $checked_modyfikacja/></td>
					<td class=dot><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' $checked_usuwanie/></td>
					<td class=dot><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' $checked_bezograniczen/></td>
					</tr>
					";
					$checked_odczyt = '';
					$checked_wprowadzanie = '';
					$checked_modyfikacja = '';
					$checked_usuwanie = '';
					$checked_bezograniczen = '';
					}
				if ($wniosek[status_wn] != '3')
					{
					echo "
					<tr>
					<td class=dot>$sysmod[nazwa_sys]</td>
					<td class=dot>$sysmod[nazwa_mod]</td>
					<td class=dot>$odczytimg</td>
					<td class=dot>$wprowadzanieimg</td>
					<td class=dot>$modyfikacjaimg</td>
					<td class=dot>$usuwanieimg</td>
					<td class=dot>$bezograniczenimg</td>
					";
					if ($wniosek[status_wn] == 9)
						{
						echo "
						<td class=dot>$sysmod[login_mod]</td>
						<td class=dot>$sysmod[haslo_mod]</td>
						";
						}
					echo "
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
		<br><br>
		";
		
				
		if (($wniosek_user == 'kxx') && ($wniosek[status_wn] == '3'))
			{
			$uwaga_connect=mysql_connect("localhost", "root", "pwtychy");
			mysql_query("SET NAMES latin2");
			$jaka_uwaga=mysql_db_query("ewidencja", "select * from uwagi_wn where id_wn = '$idwn'");
			$ile_uwag=mysql_num_rows($jaka_uwaga);
			echo "<table>";
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
			</table>
			<input type=hidden name=idwnpost value='$idwn'>
			<input type=submit name=poprawionywniosek value='Popraw wniosek'>
			</form>
			";
			}

		}
		

?>