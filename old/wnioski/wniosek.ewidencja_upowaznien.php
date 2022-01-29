<?

echo "
<br><br>
";
if ((!wniosekstget) || ($wniosekstget == "") || ($wniosekstget == "wazne"))
		{
		$wnst = 'wazne';
		echo "<a href=?wniosekstget=niewazne>Upowa¿nienia odwo³ane</a>";
		}
	
	if ($wniosekstget == 'niewazne')
		{
		$wnst = 'niewazne';
		echo "<a href=?wniosekstget=wazne>Upowa¿nienia wa¿ne</a>";
		}
	if ($wnst == "wazne")
		{$stwnqry = 9;}
	if ($wnst == "niewazne")
		{$stwnqry = 11;}

echo "
<a href=ewidencja.druk.php?wnst=$wnst onclick=this.target='_blank'>Wydrukuj ewidencjê</a><br><br>
<table class=dot>
	<tr class=wn_top>
	<td class=dot>LP</td>
	<td class=dot>Imiê</d>
	<td class=dot>Nazwisko</td>
	<td class=dot>Data z³o¿enia</td>
	<td class=dot>Data zatwierdzenia</td>
	<td class=dot>Obowi±zuje od</td>
	<td class=dot>Obowi±zuje do</td>
	<td class=dot>Podgl±d</td>
	</tr>
	";
	
	$odw_up_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$list_ewidencja_upowaznien_qry=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, wnioski.data_zl, wnioski.data_zat, 
	wnioski.data_od, wnioski.data_do, dokumenty_wnioski.link_dok 
	from wnioski 
	left join dokumenty_wnioski
	on wnioski.id_wn = dokumenty_wnioski.id_wn
	where wnioski.status_wn = $stwnqry");
	
	$ile_list_ewidencja_upowaznien=mysql_num_rows($list_ewidencja_upowaznien_qry);
	for($i = 0; $i < $ile_list_ewidencja_upowaznien; $i++)
		{
		$list_ewidencja_upowaznien=mysql_fetch_array($list_ewidencja_upowaznien_qry);	
		if (($list_ewidencja_upowaznien[data_do] == "0000-00-00") || ($list_ewidencja_upowaznien[data_do] == NULL))
			{$list_ewidencja_upowaznien[data_do] = "do odwo³ania";}
		$data_dzis = date("Y-m-d");
		$data_dzis_str = strtotime($data_dzis);
		$data_str = strtotime($list_ewidencja_upowaznien[data_do]);
	    $daty = $data_str-$data_dzis_str;
		if (($list_ewidencja_upowaznien[data_do] != "0000-00-00") && ($list_ewidencja_upowaznien[data_do] != "do odwo³ania") && ($list_ewidencja_upowaznien[data_do] != NULL) && ($daty<0))
			{
			$list_ewidencja_upowaznien[data_do] = "up³ynê³o";
			}
		$lp=$i+1;
		
		echo "
		<tr class=topdot>
		<td class=dot>
		$lp
		</td>
		<td class=dot>
		<a href=wniosek.php?det=pw&idwn=$list_ewidencja_upowaznien[id_wn]>$list_ewidencja_upowaznien[imie]</a>
		</td>
		<td class=dot>
		<a href=wniosek.php?det=pw&idwn=$list_ewidencja_upowaznien[id_wn]>$list_ewidencja_upowaznien[nazwisko]</a>
		</td>
		<td class=dot>
		$list_ewidencja_upowaznien[data_zl]
		</td>
		<td class=dot>
		$list_ewidencja_upowaznien[data_zat]
		</td>
		<td class=dot>
		$list_ewidencja_upowaznien[data_od]
		</td>
		<td class=dot>
		$list_ewidencja_upowaznien[data_do]
		</td>
		<td class=dot>
		<a href=dokumenty/$list_ewidencja_upowaznien[link_dok]  target='_blank' title=' podgl±d pliku $list_ewidencja_upowaznien[link_dok]'><img src=img/dokument.jpg></a>
		</td>
		</tr>
		";
		}
	echo "
	</table>
	";






?>