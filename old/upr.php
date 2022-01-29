<?php
$DBconnect=mysql_connect("localhost", "root", "pwtychy");
$qry1 = mysql_db_query("ewidencja", "SELECT ewidencja.uprawnienia.id_wn,uprawnienia.id_zaspap, uprawnienia.id_mod,
(16*odczyt+8*wprowadzanie+4*modyfikacja+2*usuwanie+bezograniczen) as x 
FROM `uprawnienia` left join ewidencja_dev.wniosek
on ewidencja.uprawnienia.id_wn = ewidencja_dev.wniosek.id_wn
left join ewidencja_dev.modul
on ewidencja.uprawnienia.id_mod = ewidencja_dev.modul.id_mod
left join ewidencja_dev.zasob_papierowy
on ewidencja_dev.zasob_papierowy.id_zp = ewidencja.uprawnienia.id_zaspap
where ewidencja.uprawnienia.id_wn>130 and
wniosek.nazwisko is not null and
(modul.id_mod is not null or
zasob_papierowy.id_zp is not null)
having x >0");
$ile1 = mysql_num_rows($qry1);
for($i=0;$i<$ile1;$i++) {
	$upr = mysql_fetch_array($qry1);
	
	if ($upr[id_mod] == 0) {
		$qry2 = mysql_db_query("ewidencja_dev", "insert into ewidencja_dev.uprawnienie_wniosek
		(upr_bit, id_zaspap, id_mod, id_wn) values ('$upr[x]', '$upr[id_zaspap]',
		NULL, '$upr[id_wn]')
		");
	}
	if ($upr[id_zaspap] == 0) {
		$qry2 = mysql_db_query("ewidencja_dev", "insert into ewidencja_dev.uprawnienie_wniosek
		(upr_bit, id_zaspap, id_mod, id_wn) values ('$upr[x]', NULL,
		'$upr[id_mod]', '$upr[id_wn]')
		");
	}
	echo "$upr[id_wn] - $upr[id_zaspap] - $upr[id_mod] - $upr[x]";
	echo mysql_error();
	echo "<br>";
}

?>