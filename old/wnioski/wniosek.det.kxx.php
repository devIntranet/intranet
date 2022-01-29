<?

echo "
	$menu	
	";
$hover="onMouseOver=\"this.style.backgroundColor='#E1EAFE'\"; onMouseOut=\"this.style.backgroundColor='transparent'\"";
if ($det == 'copup') $d = 1;
if ($det == '2') $d = $ddet;
if (($det == 'zmwn') && ($wniosek_user == 'kxx'))
	{
	$d = 2;
	$zatwn_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$zatwn=mysql_db_query("ewidencja", "update wnioski set status_wn = '1', full_zaspap = '$fullzaspap', full_sysmod='$fullsysmod' where id_wn = '$idwnpost'");
	}
if ($det=='odwwnkier')
	{
	$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$odwolaj=mysql_db_query("ewidencja", "update wnioski set status_wn = 12 where id_wn = '$idwn' ");
	require("mailtokxx3.php");
	}

if ($d == 1)
	{
	
	echo "
	<br>
	<br>
	<br>
	<table>
	<tr>
	<form name=addwn action=wniosek.php?det=dw method=post onSubmit='sprawdz_addwn();return false;'>
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
			$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz from dzialy 
			where id_u = $user_dzial[id_u]");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			if ($ile_dzialow > 1)
				{
				echo "
				<select name=jakidzial>
				";
				for($i = 0; $i < $ile_dzialow; $i++)
					{
					$dzialy=mysql_fetch_array($jakie_dzialy);
					echo "
					<option value='$dzialy[id_dz]'>$dzialy[nazwa_d]</option>
					";
					}
				echo "</select>";
				}
			if ($ile_dzialow == 1)
				{
				$dzialy=mysql_fetch_array($jakie_dzialy);
				echo "
				$dzialy[nazwa_d]
				<input type=hidden name=jakidzial value=$dzialy[id_dz]>
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
				
		<table>
		
		</table>
		";
	if ($det == 'copup')
		{
		$idzaspap = $zaspap[id_zaspap];
		$uprawnienia_select=mysql_db_query("ewidencja", "select * from wnioski where id_wn = $idwn");
		$uprawnienia=mysql_fetch_array($uprawnienia_select);
			if ($uprawnienia[full_zaspap] == 1)
				{
				echo "
				<input type=checkbox name=fullzaspap value=1 checked=checked> Pe³ny dostêp do zasobów papierowych<br><br> 
				";
				}
			if ($uprawnienia[full_zaspap] != 1)
				{
				echo "
				<input type=checkbox name=fullzaspap value=1> Pe³ny dostêp do zasobów papierowych<br><br> 
				";
				}
		}
	if ($det != 'copup')
		{
		echo "
		<input type=checkbox name=fullzaspap value=1> Pe³ny dostêp do zasobów papierowych<br><br> 
		";
		}
	
	for($j = 0; $j < $ile_dzialow; $j++)
		{
		$dzialy2=mysql_fetch_array($jakie_dzialy);
		if ($det == 'copup')
			{
			$jakie_zaspap_selected=mysql_db_query("ewidencja", "select max(odczyt), max(wprowadzanie), max(modyfikacja), max(usuwanie), max(bezograniczen)

			from uprawnienia 

			left join zasoby_papierowe

			on zasoby_papierowe.id_zaspap = uprawnienia.id_zaspap

                        where id_dz = $dzialy2[id_dz]

			and id_wn=$idwn

			and uprawnienia.id_zaspap > 0");
			$zaspap_select = mysql_fetch_array($jakie_zaspap_selected);
			if (($zaspap_select[0] > 0) || ($zaspap_select[1] > 0) || ($zaspap_select[2] > 0) || ($zaspap_select[3] > 0) || ($zaspap_select[4] > 0))
				{
				$zaspap_main_chacked = "checked=checked";
				}
			}
		$jakie_zaspap=mysql_db_query("ewidencja", "select nazwa_zaspap, id_zaspap from zasoby_papierowe where id_dz = '$dzialy2[id_dz]'");
		$ile_zaspap=mysql_num_rows($jakie_zaspap);
		echo "
		<input type='checkbox' name='$dzialy2[symbol_d]' value='warto¶æ' 
		onmouseover=\"document.getElementById('$dzialy2[id_dz]').style.display = this.checked? 'block' : 'none'; \"
		onclick=\"document.getElementById('$dzialy2[id_dz]').style.display = this.checked? 'block' : 'none'; \" $zaspap_main_chacked/>
		
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
		$zaspap_main_chacked = "";
		for($i = 0; $i < $ile_zaspap; $i++)
				{
				if (!$det == 'copup')
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
					<td class=dot><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1' onclick=\"checkAll(this, 'tr');\"/></td>
					</tr>
					";
					}
				if ($det == 'copup')
					{
					$zaspap=mysql_fetch_array($jakie_zaspap);
					$idzaspap = $zaspap[id_zaspap];
					$uprawnienia_select=mysql_db_query("ewidencja", "select * from uprawnienia where id_wn = $idwn and id_zaspap = $idzaspap");
					$uprawnienia=mysql_fetch_array($uprawnienia_select);
					if ($uprawnienia[odczyt] == 1) $checked_odczyt = 'checked=checked';
					if ($uprawnienia[wprowadzanie] == 1) $checked_wprowadzanie = 'checked=checked';
					if ($uprawnienia[modyfikacja] == 1) $checked_modyfikacja = 'checked=checked';
					if ($uprawnienia[usuwanie] == 1) $checked_usuwanie = 'checked=checked';
					if ($uprawnienia[bezograniczen] == 1) $checked_bezograniczen = 'checked=checked';
					echo "
					<tr $hover>
					<td class=dot>$zaspap[nazwa_zaspap]</td>
					<td class=dot><input type=checkbox name='odczyt_zaspap[$idzaspap]' value='1' $checked_odczyt/></td>
					<td class=dot><input type=checkbox name='wprowadzanie_zaspap[$idzaspap]' value='1' $checked_wprowadzanie/></td>
					<td class=dot><input type=checkbox name='modyfikacja_zaspap[$idzaspap]' value='1' $checked_modyfikacja/></td>
					<td class=dot><input type=checkbox name='usuwanie_zaspap[$idzaspap]' value='1' $checked_usuwanie/></td>
					<td class=dot><input type=checkbox name='bezograniczen_zaspap[$idzaspap]' value='1' $checked_bezograniczen/></td>
					</tr>
					";
					$checked_odczyt = '';
					$checked_wprowadzanie = '';
					$checked_modyfikacja = '';
					$checked_usuwanie = '';
					$checked_bezograniczen = '';
					}
				}
		echo "</table>";
		}
		
	echo "
	<hr>
	<br>
	";
	
	$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.id_sys, systemy.nazwa_sys, moduly.id_mod, moduly.nazwa_mod, 
	uprawnienia_default.id_ud, uprawnienia_default.odczyt, uprawnienia_default.wprowadzanie, 
	uprawnienia_default.modyfikacja, uprawnienia_default.usuwanie, uprawnienia_default.bez_ograniczen 
	from systemy
	join moduly
	on systemy.id_sys = moduly.id_sys
	left join uprawnienia_default
	on moduly.id_mod = uprawnienia_default.id_mod
	where mod_enable = 1
	order by id_sys, id_mod
	");
	$ile_sysmod=mysql_num_rows($jakie_sysmod);
	echo "
	<h5>2. Aplikacje, programy, systemy umieszczone na serwerach/komputerze</h5>
	";
	if ($det == 'copup')
		{
		$idzaspap = $zaspap[id_zaspap];
		$uprawnienia_select=mysql_db_query("ewidencja", "select * from wnioski where id_wn = $idwn");
		$uprawnienia=mysql_fetch_array($uprawnienia_select);
		if ($uprawnienia[full_sysmod] == 1)
			{
			echo "
			<input type=checkbox name=fullsysmod value=1 checked=checked> Pe³ny dostêp do zasobów systemowych<br><br> 
			";
			}
		if ($uprawnienia[full_sysmod] != 1)
			{
			echo "
			<input type=checkbox name=fullsysmod value=1> Pe³ny dostêp do zasobów systemowych<br><br> 
			";
			}
		}
	if ($det != 'copup')
		{
		echo "
		<input type=checkbox name=fullsysmod value=1> 
		Pe³ny dostêp do zasobów systemowych
		<br><br>
		";
		}
	echo "
	<table class=dot>
	<tr>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Systemu /<br> Programu / Aplikacji</div></td>
	<td class=dot><div style=' font-weight: bold;'>Nazwa Modu³u</div></td>
	";
	if (!$det == 'copup')
		{
		echo "
		<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Dostêp</div></td>
		";
		}
		
	echo "
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Odczyt</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Wprowadzanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Modyfikacja danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Usuwanie danych</div></td>
	<td class=dot><div style=' layout-flow : vertical-ideographic; font-weight: bold; text-align: left'>Bez ograniczeñ</div></td>
	</tr>
	";
	for($i = 0; $i < $ile_sysmod; $i++)
				{
				if (!$det == 'copup')
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
					echo "
					<tr $hover>
					<td class=dot>$sysmod[nazwa_sys]</td>
					<td class=dot>$sysmod[nazwa_mod]</td>
					<td class=dot><div name=raz><input type=checkbox name='dostep_sysmod[$idsysmod]' value='1' $def_box/></td>
					<td class=dot><div name='1'><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
					<td class=dot><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
					<td class=dot><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
					<td class=dot><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' disabled='disabled'/></td>
					<td class=dot><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' onclick=\"checkAll(this, 'tr');\" disabled='disabled'/></td>
					</tr>
					";
					}
				if ($det == 'copup')
					{
					$sysmod=mysql_fetch_array($jakie_sysmod);
					$idsysmod = $sysmod[id_mod];
					$uprawnienia_select=mysql_db_query("ewidencja", "select * from uprawnienia where id_wn = $idwn and id_mod = $idsysmod");
					$uprawnienia=mysql_fetch_array($uprawnienia_select);
					if ($uprawnienia[odczyt] == 1) $checked_odczyt = 'checked=checked';
					if ($uprawnienia[wprowadzanie] == 1) $checked_wprowadzanie = 'checked=checked';
					if ($uprawnienia[modyfikacja] == 1) $checked_modyfikacja = 'checked=checked';
					if ($uprawnienia[usuwanie] == 1) $checked_usuwanie = 'checked=checked';
					if ($uprawnienia[bezograniczen] == 1) $checked_bezograniczen = 'checked=checked';
					
					
					echo "
					<tr $hover>
					<td class=dot>$sysmod[nazwa_sys]</td>
					<td class=dot>$sysmod[nazwa_mod]</td>
					
					<td class=dot_def><input type=checkbox name='odczyt_sysmod[$idsysmod]' value='1' $checked_odczyt/></td>
					<td class=dot><input type=checkbox name='wprowadzanie_sysmod[$idsysmod]' value='1' $checked_wprowadzanie/></td>
					<td class=dot><input type=checkbox name='modyfikacja_sysmod[$idsysmod]' value='1' $checked_modyfikacja/></td>
					<td class=dot><input type=checkbox name='usuwanie_sysmod[$idsysmod]' value='1' $checked_usuwanie/></td>
					<td class=dot><input type=checkbox name='bezograniczen_sysmod[$idsysmod]' value='1' $checked_bezograniczen onclick=\"checkAll(this, 'tr');\"/></td>
					</tr>
					";
					$checked_odczyt = '';
					$checked_wprowadzanie = '';
					$checked_modyfikacja = '';
					$checked_usuwanie = '';
					$checked_bezograniczen = '';
					}
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
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od, data_do, full_zaspap, full_sysmod) 
			values ('$nazwisko', '$imie', '$jakidzial', '$user_dzial[id_u]', 1, CURDATE(), CURDATE(), '$datado', '$fullzaspap', '$fullsysmod')");
			}
		if (!$datado)
			{
			$insert_wniosek=mysql_db_query("ewidencja", "insert into wnioski (nazwisko, imie, id_dz, id_u, status_wn, data_zl, data_od, full_zaspap, full_sysmod) 
			values ('$nazwisko', '$imie', '$jakidzial', '$user_dzial[id_u]', 1, CURDATE(), CURDATE(), '$fullzaspap', '$fullsysmod')");
			}
		$auto_inc_id=mysql_insert_id($insert_wniosek_connect);
		mysql_close($insert_wniosek_connect);
		echo "
		<h2>Poda³e¶ dane:</h2>
		Imiê: $imie<br>
		Nazwisko: $nazwisko
		<hr><br>
		";
		require("mailtokxx1.php");
		//require("mailtoni1.php");	
		}
	if ($det == 'popw')
		{
		if ($datado)
			{
			$popraw_in_wniosek=mysql_db_query("ewidencja", "update wnioski set imie = '$imie', nazwisko = '$nazwisko',data_do = '$datado', 
			full_zaspap = '$fullzaspap', full_sysmod = '$fullsysmod' 
			where id_wn = '$idwnpost'");
			}
		if (!$datado)
			{
			$popraw_in_wniosek=mysql_db_query("ewidencja", "update wnioski set imie = '$imie', nazwisko = '$nazwisko', 
			full_zaspap = '$fullzaspap', full_sysmod = '$fullsysmod' 
			where id_wn = '$idwnpost'");
			}		

		$znajdz_wniosek=mysql_db_query("ewidencja", "select * from wnioski where id_wn = '$idwnpost'");
		$wniosek=mysql_fetch_array($znajdz_wniosek);
		mysql_close($insert_wniosek_connect);
		echo "
		<h2>Poprawiony wniosek:</h2>
		Imiê: $wniosek[imie]<br>
		Nazwisko: $wniosek[nazwisko]
		<hr><br>
		";
		require("mailtokxx2.php");
		}
	echo "
	<h2>Zasoby papierowe</h2>
	";
	if ($fullzaspap)
		{
		echo "<input type=checkbox value=1 checked=checked> Pe³ny dostêp do zasobów papierowych<br><br>";
		}
	echo "
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
				//if (($odczyt_arr[$idzaspap2] == 1) || ($wprowadzanie_arr[$idzaspap2] ==1 ) || ($modyfikacja_arr[$idzaspap2] == 1)
				//|| ($usuwanie_arr[$idzaspap2] == 1) || ($bezograniczen_arr[$idzaspap2] == 1))
				//	{
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
				//	}
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
			";
			if ($fullsysmod)
				{
				echo "<input type=checkbox value=1 checked=checked> Pe³ny dostêp do zasobów systempowych<br>";
				}
			echo "
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
				<tr $hover>
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
		$update_wniosek=mysql_db_query("ewidencja", "update wnioski set status_wn = '4', data_mod = CURDATE(), full_zaspap = '$fullzaspap', full_sysmod = '$fullsysmod'
		 where id_wn = '$idwnpost'");
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
				//if (($odczyt_arr[$idsysmod2] == 1) || ($wprowadzanie_arr[$idsysmod2] ==1 ) || ($modyfikacja_arr[$idsysmod2] == 1)
				//|| ($usuwanie_arr[$idsysmod2] == 1) || ($bezograniczen_arr[$idsysmod2] == 1))
				//	{
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
				//	}
				
				echo "
				<tr $hover>
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
	<tr class=wn_top>
	<td>Nazwisko 
	</td>
	<td>Imie 
	</td>
	<td>Dzial</td>
	<td>Wniosek z³o¿y³
	</td>
	<td>Status
	</td>
	<td>Data z³o¿enia 
	</td>
	<td>Data zatwierdzenia 
	</td>
	<td>Data ostatniej <br> modyfikacji 
	</td>
	<td>Skopiuj <br>uprawnienia</td>
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
	
	if ($wniosek_user == 'kxx')
		{
		$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, dzialy.symbol_d, 
		uzytkownicy.nazwa_u, uzytkownicy.imie_u, wnioski.status_wn, wnioski.data_zl, wnioski.data_zat, wnioski.data_mod
		from wnioski
		left join uzytkownicy
		on wnioski.id_u = uzytkownicy.id_u
		left join dzialy
		on uzytkownicy.id_dz = dzialy.id_dz
		where wnioski.id_dz = $user_dzial[id_dz] 
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
				<td><a href=wniosek.php?det=pw&idwn=$wnioski[id_wn]>$wnioski[nazwisko]</a></td>
				<td><a href=wniosek.php?det=pw&idwn=$wnioski[id_wn]>$wnioski[imie]</a></td>
				<td>$wnioski[symbol_d]</td>
				<td>$wnioski[nazwa_u] $wnioski[imie_u]</td>
				<td>$status[$status_fetch]</td>
				<td>$wnioski[data_zl]</td>
				<td>$wnioski[data_zat]</td>
				<td>$wnioski[data_mod]</td>
				<td><a href=wniosek.php?det=copup&idwn=$wnioski[id_wn]>kopiuj</a></td>
				</tr>
				";
				}
			}
	
	}

if (($det == 'pw') || ($det == 'dozmwn'))
	{
	$det_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$det_wniosek=mysql_db_query("ewidencja", "select nazwisko, imie, status_wn, data_do, full_zaspap, full_sysmod from wnioski where id_wn = '$idwn'");
	$wniosek=mysql_fetch_array($det_wniosek);
	if ($wniosek[data_do] != NULL) $datado="$wniosek[data_do]";
	if ($wniosek[data_do] == NULL) $datado="----"; 
	
	if ($wniosek[status_wn] == 3)
		{
		echo "
		<h2>Szczegó³y wniosku:</h2>
		<form action=wniosek.php?det=popw method=post onSubmit='sprawdz_addwn();return false;'>
		Imiê: <input type=text name=imie value='$wniosek[imie]'><br>
		Nazwisko: <input type=text name=nazwisko value='$wniosek[nazwisko]'><br>
		";
		if ($popdate == 1)
			{
			echo"
			Obowi±zuje do: <script>DateInput('datado', false, 'YYYY-MM-DD')</script><br>
			";
			}
		if ($popdate != 1)
			{
			echo"
			Obowi±zuje do: $datado <a href=wniosek.php?det=pw&idwn=$idwn&popdate=1>popraw datê</a><br>
			";
			}
		}
	if ($wniosek[status_wn] != 3)
		{
		echo "
		<h2>Szczegó³y wniosku:</h2>
		
		Imiê: $wniosek[imie]<br>
		Nazwisko: $wniosek[nazwisko]<br>
		Obowi±zuje do: $datado<br>
		";
		}
		
	if ($wniosek[status_wn] > 8)
		{
		$dok_wniosek_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$dok_wniosek=mysql_db_query("ewidencja", "select * from dokumenty_wnioski where id_wn = '$idwn'");
		$ile_dok_wnioskow=mysql_num_rows($dok_wniosek);
		for($i = 0; $i < $ile_dok_wnioskow; $i++)
			{
			$pokaz_dok_wniosek=mysql_fetch_array($dok_wniosek);
			$odwolania = "odwolania/";
			
			if ($pokaz_dok_wniosek[typ_dok] == 0)
				{
				echo "
				<a href=dokumenty/$pokaz_dok_wniosek[link_dok]  target='_blank' title=' podgl±d pliku $pokaz_dok_wniosek[link_dok]'>
				<img src=img/dokument.jpg border=0>
				</a>
				";
				}
			
			if ($pokaz_dok_wniosek[typ_dok] == 2)
				{
				echo "
				<a href=dokumenty/$odwolania$pokaz_dok_wniosek[link_dok]  target='_blank' title=' podgl±d pliku $pokaz_dok_wniosek[link_dok]'>
				<img src=img/dokument.jpg border=0>
				</a>
				";
				}
			}
		}
		

		echo "
		<hr><br>
		<h2>Zasoby papierowe</h2>
		";
		if (($wniosek[full_zaspap] == 1) && ($wniosek[status_wn] == 3))
			{
			echo "
			<input type=checkbox name=fullzaspap value=1 checked=checked> Pe³ny dostêp do zasobów papierowych<br><br>
			";
			}
		if (($wniosek[full_zaspap] == 1) && ($wniosek[status_wn] != 3))
			{
			echo "
			<img src=img/checked.gif> Pe³ny dostêp do zasobów papierowych<br><br>
			";
			}
		if (($wniosek[full_zaspap] != 1) && ($wniosek[status_wn] == 3))
			{
			echo "
			<input type=checkbox name=fullzaspap value=1> Pe³ny dostêp do zasobów papierowych<br><br>
			";
			}
		
		echo "
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
			";
			if (($wniosek[full_sysmod] == 1) && ($wniosek[status_wn] == 3))
			{
			echo "
			<input type=checkbox name=fullsysmod value=1 checked=checked> Pe³ny dostêp do zasobów systemowych<br><br>
			";
			}
			if (($wniosek[full_sysmod] == 1) && ($wniosek[status_wn] != 3))
			{
			echo "
			<img src=img/checked.gif> Pe³ny dostêp do zasobów systemowych<br><br>
			";
			}
			if (($wniosek[full_sysmod] != 1) && ($wniosek[status_wn] == 3))
			{
			echo "
			<input type=checkbox name=fullsysmod value=1> Pe³ny dostêp do zasobów systemowych<br><br>
			";
			}

			echo "
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
	if ($wniosek[status_wn] == 9)
		{
		echo "
		<form action=wniosek.php?det=odwwnkier&idwn=$idwn method=post>
		<input type=hidden name=d value=2>
		<input type=submit name=odwolaj value='odwo³aj upowa¿nienie'>
		</form>
		";
		}
if ($det == 'addzaspap2')
	{
	$addzaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$iddzquery=mysql_db_query("ewidencja", "select * from dzialy where symbol_d = '$department'");
	$iddzfetch=mysql_fetch_array($iddzquery);
	$iddzfind=$iddzfetch[id_dz];
	$addzaspap=mysql_db_query("ewidencja", "insert into zasoby_papierowe (id_pok, id_dz, nazwa_zaspap, id_zb)
	values ('$idpok', '$iddz', '$nazwazaspap', '$idzb')");
	$d=5;
	}
if ($d == 5)
	{
	echo "
	<br>
	<br>
	<table>
	<tr class=wn_top>
	<td>Nazwa zasobu</td>
	<td>Zbiór danych</td>
	<td>Dzial</td>
	<td>Nr pokoju</td>
	<td>Edytuj</td>
	</tr>
	";
	
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, 
	zasoby_papierowe.id_zaspap, zasoby_papierowe.id_zb, zbiory_do.skrnazwa_zb, dzialy.id_dz, dzialy.symbol_d
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok
	left join zbiory_do
	on zbiory_do.id_zb = zasoby_papierowe.id_zb
	where dzialy.id_u = '$user_dzial[id_u]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		echo "
		<tr>
		<td>$zaspap[nazwa_zaspap]</td>
		<td>$zaspap[skrnazwa_zb]</td>
		<td>$zaspap[symbol_d]</td>
		<td>$zaspap[id_pok]</td>
		<td><a href=wniosek.php?det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
		</tr>
		";
		}
	echo "
	<form action=wniosek.php?det=addzaspap method=post>
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
	<tr class=wn_top>
	<td>Nazwa zasobu</td>
	<td>Zbiór danych</td>
	<td>Dzial</td>
	<td>Nr pokoju</td>
	<td>Edytuj</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, 
	pokoje.id_pok, zasoby_papierowe.id_zaspap, zbiory_do.skrnazwa_zb, zbiory_do.id_zb, dzialy.id_dz, dzialy.symbol_d
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok
	left join zbiory_do
	on zbiory_do.id_zb = zasoby_papierowe.id_zb
	where dzialy.id_u = '$user_dzial[id_u]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		if ($zaspap[id_zaspap] != $idzaspap)
			{
			echo "
			<tr>
			<td>$zaspap[nazwa_zaspap]</td>
			<td>$zaspap[skrnazwa_zb]</td>
			<td>$zaspap[symbol_d]</td>
			<td>$zaspap[id_pok]</td>
			<td><a href=wniosek.php?det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
			</tr>
			";
			}
		if ($zaspap[id_zaspap] == $idzaspap)
			{
			echo "
			<form name=edzaspapform action=wniosek.php?det=edzaspap2&idzaspap=$idzaspap method=post onSubmit='sprawdz_edzaspapform();return false;'>
			<tr>
			<td><input type=text name=nazwazaspap value='$zaspap[nazwa_zaspap]' size=100%></td>			
			<td><select name=idzb>
			";
			$jakie_zbiory=mysql_db_query("ewidencja", "select id_zb, skrnazwa_zb from zbiory_do");
			$ile_zbiorów=mysql_num_rows($jakie_zbiory);
			for($ii = 0; $ii < $ile_zbiorów; $ii++)
				{
				$skrnazwa=mysql_fetch_array($jakie_zbiory);
				echo "
				<option value='$skrnazwa[id_zb]'>$skrnazwa[skrnazwa_zb]</option>
				";
				}

			echo "
			</td>			
			<td>
			";	
			$jakie_dzialy=mysql_db_query("ewidencja", "select dzialy.symbol_d, dzialy.id_dz from dzialy 

			where id_u = $user_dzial[id_u]

			order by symbol_d asc");
			$ile_dzialow=mysql_num_rows($jakie_dzialy);
			if ($ile_dzialow > 0)
				{
				echo "
				<select name=iddz>
				";
				for($jj = 0; $jj < $ile_dzialow; $jj++)
					{
					$dzial=mysql_fetch_array($jakie_dzialy);
					echo "
					<option value='$dzial[id_dz]'>$dzial[symbol_d]</option>
					";
					}
				echo "
				</select>
				";
				}

			
			$jakie_pokoje=mysql_db_query("ewidencja", "select dzialy.nazwa_d, pokoje.id_dz, pokoje.id_pok from dzialy 

			left join uzytkownicy

			on uzytkownicy.id_u = dzialy.id_u

			left join pokoje

			on pokoje.id_dz = dzialy.id_dz

			where uzytkownicy.id_u = $user_dzial[id_u]

			order by pokoje.id_pok asc");
			$ile_pokoi=mysql_num_rows($jakie_pokoje);
			echo "</td><td>";
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
			<td><input type=submit name=popraw value='Popraw'></td>
			</tr>
			</form>
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
	<tr class=wn_top>
	<td>Nazwa zasobu</td>
	<td>Dzia³</td>
	<td>Nr pokoju</td>
	<td>Zbiór danych</td>
	<td>Edytuj!!</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$popraw_zaspap=mysql_db_query("ewidencja", "update zasoby_papierowe set nazwa_zaspap = '$nazwazaspap', id_pok = '$idpok', id_zb = '$idzb', id_dz = '$iddz' 
	where id_zaspap = '$idzaspap'");
	if($popraw_zaspap)
	{
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap, 
	zbiory_do.id_zb, zbiory_do.skrnazwa_zb, dzialy.symbol_d
	from zasoby_papierowe 
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok
	left join zbiory_do
	on zbiory_do.id_zb = zasoby_papierowe.id_zb
	where dzialy.id_u = '$user_dzial[id_u]'");
	}	
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		if ($zaspap[id_zaspap] != $idzaspap)
			{
			echo "
			<tr>
			<td>$zaspap[nazwa_zaspap]</td>
			<td>$zaspap[symbol_d]</td>
			<td>$zaspap[id_pok]</td>
			<td>$zaspap[skrnazwa_zb]</td>
			<td><a href=wniosek.php?det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
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
	<tr class=wn_top>
	<td>Nazwa zasobu</td>
	<td>Zbiór danych</td>
	<td>Dzia³</td>
	<td>Nr pokoju</td>
	<td>Edytuj</td>
	</tr>
	";
	$jakie_zaspap_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.nazwa_zaspap, zasoby_papierowe.id_zaspap, pokoje.id_pok, zasoby_papierowe.id_zaspap, 
	dzialy.symbol_d, zbiory_do.id_zb, zbiory_do.skrnazwa_zb
	from zasoby_papierowe
	left join zbiory_do
	on zbiory_do.id_zb = zasoby_papierowe.id_zb
	left join dzialy
	on zasoby_papierowe.id_dz = dzialy.id_dz
	left join pokoje
	on pokoje.id_pok = zasoby_papierowe.id_pok
	where dzialy.id_u = '$user_dzial[id_u]'");
	$ile_zaspap=mysql_num_rows($jakie_zaspap);
	
	for($i = 0; $i < $ile_zaspap; $i++)
		{
		$zaspap=mysql_fetch_array($jakie_zaspap);
		echo "
		<tr>
		<td>$zaspap[nazwa_zaspap]</td>
		<td>$zaspap[skrnazwa_zb]</td>
		<td>$zaspap[symbol_d]</td>
		<td>$zaspap[id_pok]</td>
		<td><a href=wniosek.php?det=edzaspap&idzaspap=$zaspap[id_zaspap]>Edytuj</a></td>
		</tr>
		";
		}
	echo "
	<form name=addzaspapform action=wniosek.php?det=addzaspap2 method=post onSubmit='sprawdz_addzaspapform();return false;'>
	<tr>
	<td><input type=text name=nazwazaspap size=100%></td>
	<td><select name=idzb>
	";
	$jakie_zbiory=mysql_db_query("ewidencja", "select id_zb, skrnazwa_zb from zbiory_do");
	$ile_zbiorów=mysql_num_rows($jakie_zbiory);
	for($ii = 0; $ii < $ile_zbiorów; $ii++)
			{
			$skrnazwa=mysql_fetch_array($jakie_zbiory);
			echo "
			<option value='$skrnazwa[id_zb]'>$skrnazwa[skrnazwa_zb]</option>
			";
			}

	echo "
	</td>			
	<td>
	";
	$jakie_dzialy=mysql_db_query("ewidencja", "select dzialy.symbol_d, dzialy.id_dz	from dzialy where dzialy.id_u = $user_dzial[id_u] order by dzialy.symbol_d asc");
	$ile_dzialow=mysql_num_rows($jakie_dzialy);
	if ($ile_dzialow > 0)
		{
		echo "
		<select name=iddz>
		";
		for($jjj = 0; $jjj < $ile_dzialow; $jjj++)
			{
			$dzial=mysql_fetch_array($jakie_dzialy);
			echo "
			<option value='$dzial[id_dz]'>$dzial[symbol_d]</option>
			";
			}
		echo "
		</select>
		";
		}
		echo "
	</td>			
	<td>
	";
	$jakie_pokoje=mysql_db_query("ewidencja", "select dzialy.nazwa_d, pokoje.id_dz, pokoje.id_pok from dzialy 

			left join uzytkownicy

			on uzytkownicy.id_u = dzialy.id_u

			left join pokoje

			on pokoje.id_dz = dzialy.id_dz

			where uzytkownicy.id_u = $user_dzial[id_u]

			order by pokoje.id_pok asc");
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
?>